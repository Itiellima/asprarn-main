<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinanceiroCategoria;
use App\Models\FinanceiroContaBancaria;
use App\Models\FinanceiroLancamento;
use App\Services\Financeiro\LancamentoService;
use DomainException;
use Illuminate\Http\Request;

/**
 * Contas a pagar (despesas) e a receber (receitas).
 * O tipo vem da rota (->defaults('tipo', ...)): as duas telas usam este mesmo
 * controller e as mesmas views; os dados são lançamentos do financeiro.
 */
class ContasController extends Controller
{
    private const CONFIG = [
        'despesa' => [
            'titulo' => 'Contas a pagar',
            'singular' => 'Conta a Pagar',
            'rota' => 'contas-a-pagar',
            'rota_pagar' => 'financeiro.contas-a-pagar.pagar',
            'rota_cancelar' => 'financeiro.contas-a-pagar.cancelar-pagamento',
            'texto_pagar' => 'Marcar como pago',
            'texto_cancelar' => 'Cancelar pagamento',
            'data_pagamento' => 'Data de pagamento',
            'tipos' => ['despesa' => 'Despesa'],
        ],
        'receita' => [
            'titulo' => 'Contas a receber',
            'singular' => 'Conta a Receber',
            'rota' => 'contas-a-receber',
            'rota_pagar' => 'financeiro.contas-a-receber.receber',
            'rota_cancelar' => 'financeiro.contas-a-receber.cancelar-recebimento',
            'texto_pagar' => 'Marcar como recebido',
            'texto_cancelar' => 'Cancelar recebimento',
            'data_pagamento' => 'Data de recebimento',
            'tipos' => ['receita' => 'Receita'],
        ],
    ];

    private const FILTROS_SITUACAO = ['pendente', 'pago', 'cancelado', 'todas'];

    public function __construct(private LancamentoService $lancamentos)
    {
    }

    public function index(Request $request)
    {
        $config = $this->config($request);
        $situacao = in_array($request->query('situacao'), self::FILTROS_SITUACAO, true)
            ? $request->query('situacao')
            : 'pendente';

        $contas = FinanceiroLancamento::with(['categoria', 'conta'])
            ->where('tipo', $config['tipo'])
            ->when($situacao !== 'todas', fn ($q) => $q->where('situacao', $situacao))
            ->ordenadosPorSituacao()
            ->orderByRaw('data_vencimento IS NULL')
            ->orderBy('data_vencimento')
            ->orderByDesc('data_lancamento')
            ->paginate(10);

        return view('financeiro.contas.index', compact('contas', 'config', 'situacao'));
    }

    public function create(Request $request)
    {
        $config = $this->config($request);
        $conta = new FinanceiroLancamento(['tipo' => $config['tipo']]);

        return view('financeiro.contas.create', $this->dadosDoFormulario($config, $conta));
    }

    public function store(Request $request)
    {
        $config = $this->config($request);

        $this->lancamentos->criar($this->validar($request, $config) + ['situacao' => 'pendente']);

        return redirect()
            ->route($config['rota'] . '.index')
            ->with('success', $config['singular'] . ' cadastrada com sucesso.');
    }

    public function edit(Request $request)
    {
        $config = $this->config($request);
        $conta = $this->buscar($request, $config);

        return view('financeiro.contas.create', $this->dadosDoFormulario($config, $conta));
    }

    public function update(Request $request)
    {
        $config = $this->config($request);
        $conta = $this->buscar($request, $config);

        return $this->executar($config, fn () => $this->lancamentos->atualizar($conta, $this->validar($request, $config)),
            $config['singular'] . ' atualizada com sucesso.');
    }

    public function destroy(Request $request)
    {
        $config = $this->config($request);
        $conta = $this->buscar($request, $config);

        return $this->executar($config, fn () => $this->lancamentos->excluir($conta),
            $config['singular'] . ' excluída com sucesso.');
    }

    // Marca como pago/recebido (checkbox marcado) ou desfaz (desmarcado)
    public function pagar(Request $request)
    {
        $config = $this->config($request);
        $conta = $this->buscar($request, $config);

        if (!$request->boolean('situacao')) {
            return $this->executar($config, fn () => $this->lancamentos->reabrir($conta),
                $config['singular'] . ' voltou a ficar pendente.');
        }

        $request->validate(['data_pagamento' => 'required|date'], [
            'data_pagamento.required' => 'Informe a ' . strtolower($config['data_pagamento']) . '.',
        ]);

        return $this->executar($config, fn () => $this->lancamentos->pagar($conta, $request->input('data_pagamento')),
            $config['tipo'] === 'despesa' ? 'Conta marcada como paga.' : 'Conta marcada como recebida.');
    }

    public function cancelar(Request $request)
    {
        $config = $this->config($request);
        $conta = $this->buscar($request, $config);

        return $this->executar($config, fn () => $this->lancamentos->cancelar($conta),
            $config['singular'] . ' cancelada.');
    }

    private function config(Request $request): array
    {
        $tipo = $request->route('tipo');

        abort_unless(isset(self::CONFIG[$tipo]), 404);

        return self::CONFIG[$tipo] + ['tipo' => $tipo];
    }

    // Busca só lançamentos do tipo da tela (uma receita não abre em "contas a pagar")
    private function buscar(Request $request, array $config): FinanceiroLancamento
    {
        return FinanceiroLancamento::where('tipo', $config['tipo'])->findOrFail($request->route('id'));
    }

    private function validar(Request $request, array $config): array
    {
        $dados = $request->validate([
            'valor' => 'required|numeric|min:0.01',
            'data_lancamento' => 'required|date',
            'data_vencimento' => 'nullable|date',
            'repeticao' => 'nullable|in:diaria,semanal,quinzenal,mensal,anual,unica',
            'categoria_id' => 'nullable|exists:financeiro_categorias,id',
            'conta_id' => 'nullable|exists:financeiro_contas_bancarias,id',
            'descricao' => 'nullable|string|max:255',
            'observacao' => 'nullable|string',
        ]);

        return array_merge($dados, [
            'tipo' => $config['tipo'],
            'repeticao' => ($dados['repeticao'] ?? null) ?: 'unica',
        ]);
    }

    private function dadosDoFormulario(array $config, FinanceiroLancamento $conta): array
    {
        return [
            'config' => $config,
            'conta' => $conta,
            'categorias' => FinanceiroCategoria::where('tipo', $config['tipo'])->orderBy('nome')->get(),
            'contasBancarias' => FinanceiroContaBancaria::orderBy('nome')->get(),
        ];
    }

    private function executar(array $config, callable $acao, string $mensagem)
    {
        try {
            $acao();
        } catch (DomainException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route($config['rota'] . '.index')->with('success', $mensagem);
    }
}
