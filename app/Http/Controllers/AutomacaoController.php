<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Automacao;
use App\Models\Associado;
use Illuminate\Support\Facades\Http;
use App\Models\Situacao;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class AutomacaoController extends Controller
{

    public function test()
    {
        $agora = now()->toDateString();

        $automacoes = Automacao::where('ativo', true)->get();
        $resultados = [];

        foreach ($automacoes as $auto) {

            // garante valor padrão
            $deveExecutar = false;

            // Se a data atual ainda não chegou na data de início, não executa
            if ($agora < Carbon::parse($auto->data_inicio)->toDateString()) {
                continue;
            }

            // Se nunca executou, executa na data_inicio
            if (!$auto->ultima_execucao) {
                $deveExecutar = $agora >= Carbon::parse($auto->data_inicio)->toDateString();
            } else {
                // verifica intervalo usando Carbon
                $proximaExec = Carbon::parse($auto->ultima_execucao)->addDays($auto->intervalo_dias)->toDateString();
                $deveExecutar = $agora >= $proximaExec;
            }

            if (!$deveExecutar) {
                continue;
            }


            $associados = Associado::whereHas('situacoes', function ($query) use ($auto) {
                $query->where('situacoes.id', $auto->situacao_id);
            })->get();

            $resultados[] = [
                'automacao' => $auto->nome,
                'mensagem' => $auto->mensagem,
                'associados' => $associados->pluck('nome'),
                'telefones' => $associados->map(function ($assoc) {
                    return optional($assoc->contato)->tel_celular ?? $assoc->telefone ?? 'sem telefone';
                }),
            ];

            $auto->ultima_execucao = $agora;
            $auto->save();
        }


        return response()->json([
            'status' => 'ok',
            // 'automacoes' => $automacoes->pluck('nome'),
            'resultados' => $resultados
        ]);
    }

    public function executar()
    {
        $agora = now()->toDateString();
        $automacoes = Automacao::where('ativo', true)->get();

        $retornos = []; // <-- inicializa aqui

        foreach ($automacoes as $auto) {

            // garante valor padrão
            $deveExecutar = false;

            // Se a data atual ainda não chegou na data de início, não executa
            if ($agora < Carbon::parse($auto->data_inicio)->toDateString()) {
                continue;
            }

            // Se nunca executou, executa na data_inicio
            if (!$auto->ultima_execucao) {
                $deveExecutar = $agora === Carbon::parse($auto->data_inicio)->toDateString();
            } else {
                // verifica intervalo usando Carbon
                $proximaExec = Carbon::parse($auto->ultima_execucao)->addDays($auto->intervalo_dias)->toDateString();
                $deveExecutar = $agora >= $proximaExec;
            }

            if (!$deveExecutar) {
                continue;
            }

            // Filtrar associados
            $associados = Associado::where('situacao_id', $auto->situacao_id)->get();

            foreach ($associados as $assoc) {
                // pega telefone (checa relacionamento contato ou campo direto)
                $telefone = optional($assoc->contato)->tel_celular ?? $assoc->telefone ?? null;

                if (!$telefone) {
                    $retornos[] = [
                        'automacao'   => $auto->nome,
                        'associado'   => $assoc->nome,
                        'status'      => 'skipped',
                        'reason'      => 'sem telefone',
                    ];
                    continue;
                }

                try {
                    $resultado = Http::post('https://n8n.asprarn.com.br/webhook-test/776ee56a-3e3c-4e7b-81f1-fdc6dab2683b', [
                        'nome'      => $assoc->nome,
                        'mensagem'  => $auto->mensagem,
                        'from'      => $telefone,
                        'instance'  => 'AspraAdm',
                    ]);

                    $retornos[] = [
                        'automacao' => $auto->nome,
                        'associado' => $assoc->nome,
                        'status'    => $resultado->status(),
                        // tenta decodificar JSON, senão retorna body bruto
                        // 'body'      => $this->safeJson($resultado),
                    ];
                } catch (Exception $e) {
                    $retornos[] = [
                        'automacao' => $auto->nome,
                        'associado' => $assoc->nome,
                        'status'    => 'error',
                        'error'     => $e->getMessage(),
                    ];
                }
            }

            // Atualiza última execução apenas se executou (para evitar loop infinito)
            $auto->ultima_execucao = $agora;
            $auto->save();
        }

        return response()->json([
            'status' => 'ok',
            'resultados' => $retornos
        ]);
    }

    /**
     * Helper simples para obter JSON de uma resposta Http sem lançar exceção
     */
    private function safeJson($response)
    {
        try {
            return $response->json();
        } catch (Exception $e) {
            return $response->body();
        }
    }

    public function index()
    {

        $user = Auth::user();

        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }


        $automacoes = Automacao::all();
        $associados = Associado::all();
        $situacoes = Situacao::all();

        return view('automacoes.index', compact('automacoes', 'associados', 'situacoes'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }



        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'mensagem' => 'required|string',
            'data_inicio' => 'required|date',
            'intervalo_dias' => 'required|integer|min:0',
            'situacao_id' => 'required|exists:situacoes,id',
        ]);

        Automacao::create($data);

        return redirect()->route('automacoes.index')->with('success', 'Automação criada com sucesso.');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $automacao = Automacao::findOrFail($id);
        $automacao->delete();
        return redirect()->route('automacoes.index')->with('success', 'Automação deletada com sucesso.');
    }
}
