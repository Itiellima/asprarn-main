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

    // public function executar()
    // {
    //     // pega a data de hoje
    //     $agora = now()->toDateString();

    //     // pega as automacoes ativas
    //     $automacoes = Automacao::where('ativo', true)->get();
    //     // inicializa array de resultados
    //     $resultados = [];


    //     foreach ($automacoes as $auto) {

    //         // garante valor padrão false
    //         $deveExecutar = false;

    //         // data inicio
    //         $dataInicio = Carbon::parse($auto->data_inicio)->toDateString();

    //         // não executa antes da data de início
    //         if ($agora < $dataInicio) {
    //             continue;
    //         }

    //         /**
    //          * CASO 1: repetir_dias (todo mês)
    //          */
    //         if (!empty($auto->repetir_dias)) {

    //             $diaHoje = Carbon::now()->day;
    //             $diaRepetir = (int) $auto->repetir_dias;

    //             // só executa no dia configurado
    //             if ($diaHoje === $diaRepetir) {

    //                 // evita executar duas vezes no mesmo dia
    //                 if (!$auto->ultima_execucao || $auto->ultima_execucao !== $agora) {
    //                     $deveExecutar = true;
    //                 }
    //             }
    //         }
    //         /**
    //          * CASO 2: intervalo normal
    //          */
    //         else {

    //             // se nunca executou, executa na data_inicio
    //             if (!$auto->ultima_execucao) {
    //                 $deveExecutar = $agora >= $dataInicio;

    //                 // se já executou, verifica intervalo usando Carbon
    //             } else {
    //                 $proximaExec = Carbon::parse($auto->ultima_execucao)
    //                     ->addDays($auto->intervalo_dias)
    //                     ->toDateString();

    //                 $deveExecutar = $agora >= $proximaExec;
    //             }
    //         }

    //         // CASO 3: tipo_execucao específico (ex: aniversariantes)
    //         if ($auto->tipo_execucao === 'aniversario') {
    //             $deveExecutar = true;
    //         }


    //         if (!$deveExecutar) {
    //             continue;
    //         }


    //         $associados = Associado::whereHas('situacoes', function ($query) use ($auto) {
    //             $query->where('situacoes.id', $auto->situacao_id);
    //         });

    //         if ($auto->tipo_execucao === 'aniversario') {

    //             $hojeMes = now()->month;
    //             $hojeDia = now()->day;

    //             $associados->whereMonth('data_nascimento', $hojeMes)
    //                 ->whereDay('data_nascimento', $hojeDia);
    //         }

    //         $associados = $associados->get();

    //         if ($auto->tipo_execucao === 'aniversario') {
    //             if ($auto->ultima_execucao === $agora) {
    //                 continue;
    //             }
    //         }

    //         $resultados[] = [
    //             'automacao' => $auto->nome,
    //             'mensagem' => $auto->mensagem,
    //             'associados' => $associados->pluck('nome'),
    //             'telefones' => $associados->map(function ($assoc) {
    //                 return optional($assoc->contato)->tel_celular ?? $assoc->telefone ?? 'sem telefone';
    //             }),
    //         ];

    //         $auto->ultima_execucao = $agora;
    //         $auto->save();
    //     }


    //     return response()->json([
    //         'status' => 'ok',
    //         // 'automacoes' => $automacoes->pluck('nome'),
    //         'resultados' => $resultados
    //     ]);
    // }

    public function executar()
    {
        $agora = now()->toDateString();

        $automacoes = Automacao::where('ativo', true)->get();
        $resultados = [];

        foreach ($automacoes as $auto) {

            // evita executar mais de uma vez no mesmo dia
            if ($auto->ultima_execucao === $agora) {
                continue;
            }

            $deveExecutar = false;

            // data início
            $dataInicio = Carbon::parse($auto->data_inicio)->toDateString();

            if ($agora < $dataInicio) {
                continue;
            }

            /**
             * CASO 1: ANIVERSÁRIO
             */
            if ($auto->tipo_execucao === 'aniversario') {
                $deveExecutar = true;
            }

            /**
             * CASO 2: repetir_dias (mensal)
             */
            elseif (!empty($auto->repetir_dias)) {

                $diaHoje = now()->day;
                $diaRepetir = (int) $auto->repetir_dias;

                if ($diaHoje === $diaRepetir) {
                    $deveExecutar = true;
                }
            }

            /**
             * CASO 3: intervalo
             */
            else {

                if (!$auto->ultima_execucao) {
                    $deveExecutar = $agora >= $dataInicio;
                } else {
                    $proximaExec = Carbon::parse($auto->ultima_execucao)
                        ->addDays($auto->intervalo_dias)
                        ->toDateString();

                    $deveExecutar = $agora >= $proximaExec;
                }
            }

            if (!$deveExecutar) {
                continue;
            }

            /**
             * BUSCA ASSOCIADOS
             */
            $associadosQuery = Associado::whereHas('situacoes', function ($query) use ($auto) {
                $query->where('situacoes.id', $auto->situacao_id);
            });

            // filtro de aniversário
            if ($auto->tipo_execucao === 'aniversario') {

                $hojeMes = now()->month;
                $hojeDia = now()->day;

                $associadosQuery->whereMonth('dt_nasc', $hojeMes)
                    ->whereDay('dt_nasc', $hojeDia);
            }

            $associados = $associadosQuery
                ->with('contato') // evita N+1
                ->get();

            // evita execução sem ninguém
            if ($associados->isEmpty()) {
                continue;
            }

            /**
             * RESULTADO
             */
            $resultados[] = [
                'automacao' => $auto->nome,
                // mensagem personalizada
                'mensagens' => $auto->mensagem,

                'associados' => $associados->pluck('nome'),
                
                'telefones' => $associados->map(function ($assoc) {
                    return optional($assoc->contato)->tel_celular
                        ?? $assoc->telefone
                        ?? 'sem telefone';
                }),
            ];

            /**
             * ATUALIZA EXECUÇÃO
             */
            $auto->ultima_execucao = $agora;
            $auto->save();
        }

        return response()->json([
            'status' => 'ok',
            'resultados' => $resultados
        ]);
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
            'repetir_dias' => 'nullable|integer|min:1|max:31',
            'intervalo_dias' => 'nullable|integer|min:0',
            'situacao_id' => 'required|exists:situacoes,id',
            'ativo' => 'required|boolean',
            'tipo_execucao' => 'nullable|string',
        ]);

        $data['ativo'] = $request->has('ativo');
        

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
