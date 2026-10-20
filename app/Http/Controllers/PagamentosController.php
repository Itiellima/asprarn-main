<?php

namespace App\Http\Controllers;

use App\Helpers\DinheiroHelper;
use App\Helpers\MesReferenciaHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Associado;
use App\Models\Pagamento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Pagamentos dos associados (mensalidades). Cada pagamento mantém sozinho a
 * receita correspondente no financeiro (ver Pagamento::booted).
 */
class PagamentosController extends Controller
{
    // Nomes de coluna aceitos no CSV além dos oficiais (cpf, valor, mes_referencia)
    private const ALIASES_CSV = [
        'mes' => 'mes_referencia',
        'referencia' => 'mes_referencia',
        'mes_de_referencia' => 'mes_referencia',
        'competencia' => 'mes_referencia',
        'valor_pago' => 'valor',
    ];

    public function index()
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }


        // Lógica para exibir a página de pagamentos
        return view('importar-pagamentos.index');
    }

    public function readArchive(Request $request)
    {

        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        // Recebe o arquivo enviado pelo formulário
        $file = $request->file('arquivo');

        // Verifica se um arquivo foi selecionado
        if (!$file) {
            return redirect()->back()->with('error', 'Nenhum arquivo selecionado.');
        }

        $conteudo = (string) file_get_contents($file->getRealPath());

        // Excel no Windows salva CSV em ANSI (Windows-1252): converte para UTF-8 para não perder acentos
        if (!mb_check_encoding($conteudo, 'UTF-8')) {
            $conteudo = mb_convert_encoding($conteudo, 'UTF-8', 'Windows-1252');
        }

        // Remove o BOM do UTF-8, se houver
        $conteudo = preg_replace('/^\xEF\xBB\xBF/', '', $conteudo);

        $handle = fopen('php://temp', 'r+');
        fwrite($handle, $conteudo);
        rewind($handle);

        $dadosCsv = [];
        $header = null;
        $linhasLidas = 0;

        while (($linha = fgetcsv($handle, 0, ';')) !== false) {
            $linhasLidas++;

            if (empty(array_filter($linha, fn ($valor) => trim((string) $valor) !== ''))) {
                continue;
            }

            // O cabeçalho é a primeira linha que tem a coluna "cpf" (pode haver um título antes)
            if ($header === null) {
                $colunas = array_map(fn ($item) => $this->normalizarColuna($item), $linha);

                if (in_array('cpf', $colunas, true)) {
                    $header = $colunas;
                } elseif ($linhasLidas >= 5) {
                    break;
                }

                continue;
            }

            // Ignora colunas vazias no fim da linha (comum em exportações do Excel)
            $linha = array_slice(array_pad($linha, count($header), ''), 0, count($header));

            $registro = array_combine($header, array_map('trim', $linha));
            unset($registro['']);

            $dadosCsv[] = $registro;
        }

        fclose($handle);

        if ($header === null) {
            return redirect()->back()->with('error', 'Não encontrei o cabeçalho do arquivo. A planilha precisa ter as colunas cpf, valor e mes_referencia.');
        }

        return view('importar-pagamentos.index', compact('dadosCsv'));
    }

    public function processarPagamentos(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $request->validate([
            'data_pagamento' => 'nullable|date',
            'observacao' => 'nullable|string|max:255',
        ]);

        $dados = json_decode((string) $request->input('dados'), true);
        if (!is_array($dados) || empty($dados)) {
            return redirect()->back()->with('error', 'Dados inválidos para processamento.');
        }

        $dataPagamento = $request->input('data_pagamento') ?: now()->toDateString();

        $sucesso = 0;
        $falhasDetalhes = [];

        DB::beginTransaction();
        try {
            foreach ($dados as $linha) {
                $linha = is_array($linha) ? $linha : [];
                $nome = $linha['nome'] ?? 'N/A';
                $cpf = $this->normalizarCpf($linha['cpf'] ?? '');

                $falha = function (string $motivo) use (&$falhasDetalhes, $cpf, $nome) {
                    $falhasDetalhes[] = ['cpf' => $cpf, 'nome' => $nome, 'motivo' => $motivo];
                };

                if (!isset($linha['cpf'], $linha['valor'], $linha['mes_referencia'])) {
                    $falha('Linha incompleta (faltam cpf, valor ou mes_referencia)');
                    continue;
                }

                $associado = $cpf ? Associado::where('cpf', $cpf)->first() : null;

                if (!$associado) {
                    $falha('Associado não encontrado');
                    continue;
                }

                $valor = DinheiroHelper::paraDecimal($linha['valor']);

                if ($valor === null || (float) $valor <= 0) {
                    $falha('Valor inválido');
                    continue;
                }

                $mesReferencia = MesReferenciaHelper::paraData($linha['mes_referencia']);

                if (!$mesReferencia) {
                    $falha('Mês de referência inválido (use mm/aaaa)');
                    continue;
                }

                if ($this->jaExiste($associado->id, 'mensalidade', $mesReferencia)) {
                    $falha('Pagamento já registrado para este mês de referência');
                    continue;
                }

                Pagamento::create([
                    'associado_id'      => $associado->id,
                    'user_id'           => $user->id,
                    'valor'             => $valor,
                    'mes_referencia'    => $mesReferencia,
                    'data_pagamento'    => $dataPagamento,
                    'metodo_pagamento'  => 'desconto_em_folha',
                    'tipo'              => 'mensalidade',
                    'status'            => 'pago',
                    'origem'            => 'importacao_csv',
                    'observacao'        => $request->input('observacao') ?: null,
                    'associado_nome'    => $associado->nome,
                    'associado_cpf'     => $associado->cpf,
                ]);

                $sucesso++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao importar pagamentos: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Ocorreu um erro ao processar os pagamentos. Nenhum pagamento foi salvo.');
        }

        $falhasAgrupadas = collect($falhasDetalhes)->groupBy('motivo')->map->all()->all();

        return redirect()->route('importar-pagamentos.index')->with([
            'success' => 'Pagamentos processados com sucesso.',
            'sucesso' => $sucesso,
            'falhas' => count($falhasDetalhes),
            'falhasAgrupadas' => $falhasAgrupadas
        ]);
    }

    public function show($associadoId)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $associado = Associado::findOrFail($associadoId);

        $pagamentos = $associado->pagamentos()
            ->orderBy('data_pagamento', 'desc')
            ->paginate(10);

        return view('pagamentos.show', compact('pagamentos', 'associado'));
    }

    public function edit($pagamentoId)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $pagamento = Pagamento::findOrFail($pagamentoId);

        return view('pagamentos.edit', compact('pagamento'));
    }

    public function update(Request $request, $pagamentoId)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $pagamento = Pagamento::findOrFail($pagamentoId);

        $dados = $this->validarFormulario($request, $pagamento->associado_id, $pagamento->id);

        DB::transaction(fn () => $pagamento->update($dados));

        return redirect()->route('pagamentos.show', $pagamento->associado_id)->with('success', 'Pagamento atualizado com sucesso.');
    }

    public function create($associadoId)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $associado = Associado::findOrFail($associadoId);

        $pagamento = new Pagamento();

        return view('pagamentos.create', compact('associado', 'pagamento'));
    }

    public function store(Request $request, $associadoId)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $associado = Associado::findOrFail($associadoId);

        $dados = $this->validarFormulario($request, $associado->id);

        DB::transaction(fn () => Pagamento::create($dados + [
            'associado_id' => $associado->id,
            'user_id' => $user->id,
            'associado_nome' => $associado->nome,
            'associado_cpf' => $associado->cpf,
        ]));

        return redirect()->route('pagamentos.show', $associadoId)->with('success', 'Pagamento criado com sucesso.');
    }

    public function destroy($pagamentoId)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $pagamento = Pagamento::findOrFail($pagamentoId);
        $associadoId = $pagamento->associado_id;

        // A receita do financeiro é removida junto (Pagamento::booted)
        DB::transaction(fn () => $pagamento->delete());

        return redirect()->route('pagamentos.show', $associadoId)->with('success', 'Pagamento excluído com sucesso.');
    }

    public function pagamentosIndex () {

        $user = Auth::user();
        if(!$user || !$user->hasRole(['admin', 'moderador'])){
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $search = request('search');

        $pagamentos = Pagamento::with(['associado'])

        ->when(request('search'), function ($query, $search) {

            $query->whereHas('associado', function ($q) use ($search) {

                $q->where('nome', 'like', "%{$search}%")
                    ->orWhere('cpf', 'like', "%{$search}%");
            });
        })

        ->orderByDesc('mes_referencia')
        ->orderByDesc('id')
        ->paginate('10');

        return view('pagamentos.index', compact('pagamentos', 'search'));
    }

    /**
     * Valida o formulário de pagamento manual e devolve os dados prontos para salvar.
     * O valor aceita o formato brasileiro ("1.234,56") usado pela máscara do campo.
     */
    private function validarFormulario(Request $request, int $associadoId, ?int $ignorarPagamentoId = null): array
    {
        $request->validate([
            'valor' => 'required|string',
            'data_pagamento' => 'required|date',
            'mes_referencia' => 'required|string',
            'metodo_pagamento' => 'nullable|string|max:255',
            'tipo' => 'nullable|in:mensalidade,anuidade',
            'status' => 'nullable|in:pendente,pago,atrasado',
            'numero_documento' => 'nullable|string|max:255',
            'origem' => 'nullable|string|max:255',
            'observacao' => 'nullable|string',
        ]);

        $valor = DinheiroHelper::paraDecimal($request->input('valor'));
        $mesReferencia = MesReferenciaHelper::paraData($request->input('mes_referencia'));
        $tipo = $request->input('tipo') ?: 'mensalidade';

        $erros = [];

        if ($valor === null || (float) $valor <= 0) {
            $erros['valor'] = 'Informe um valor válido, por exemplo 120,00.';
        }

        if (!$mesReferencia) {
            $erros['mes_referencia'] = 'Informe um mês de referência válido.';
        } elseif ($this->jaExiste($associadoId, $tipo, $mesReferencia, $ignorarPagamentoId)) {
            $erros['mes_referencia'] = 'Já existe um pagamento de ' . $tipo . ' para este associado neste mês.';
        }

        if ($erros) {
            throw \Illuminate\Validation\ValidationException::withMessages($erros);
        }

        return [
            'valor' => $valor,
            'data_pagamento' => $request->input('data_pagamento'),
            'mes_referencia' => $mesReferencia,
            'metodo_pagamento' => $request->input('metodo_pagamento'),
            'tipo' => $tipo,
            'status' => $request->input('status') ?: 'pago',
            'numero_documento' => $request->input('numero_documento'),
            'origem' => $request->input('origem') ?: 'manual',
            'observacao' => $request->input('observacao'),
        ];
    }

    private function jaExiste(int $associadoId, string $tipo, Carbon $mesReferencia, ?int $ignorarPagamentoId = null): bool
    {
        return Pagamento::where('associado_id', $associadoId)
            ->where('tipo', $tipo)
            ->whereDate('mes_referencia', $mesReferencia->toDateString())
            ->when($ignorarPagamentoId, fn ($q) => $q->whereKeyNot($ignorarPagamentoId))
            ->exists();
    }

    // Só dígitos; recupera o zero à esquerda que o Excel remove ("1234567890" → "01234567890")
    private function normalizarCpf($cpf): string
    {
        $cpf = preg_replace('/\D/', '', (string) $cpf);

        return $cpf === '' ? '' : str_pad($cpf, 11, '0', STR_PAD_LEFT);
    }

    // "Mês de Referência" → "mes_de_referencia" → "mes_referencia"
    private function normalizarColuna($coluna): string
    {
        $coluna = (string) Str::of((string) $coluna)->ascii()->lower()->trim()->replaceMatches('/[\s\-]+/', '_');

        return self::ALIASES_CSV[$coluna] ?? $coluna;
    }
}
