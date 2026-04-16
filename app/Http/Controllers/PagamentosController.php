<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Associado;
use App\Models\Pagamento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PagamentosController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }


        // Lógica para exibir a página de pagamentos
        return view('pagamentos.index');
    }

    public function readArchive(Request $request)
    {

        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        // Lógica para ler o arquivo de pagamentos
        // Recebe o arquivo enviado pelo formulário
        $file = $request->file('arquivo');

        // Verifica se um arquivo foi selecionado
        if (!$file) {
            return redirect()->back()->with('error', 'Nenhum arquivo selecionado.');
        }

        $dadosCsv = [];

        // Abre o arquivo como se fosse ler um bloco de texto - fopen($file->getRealPath(), 'r')
        if (($handle = fopen($file->getRealPath(), 'r')) !== false) {

            // Pula a primeira linha (título)
            fgetcsv($handle, 1000, ';');

            // Pega o cabeçalho do CSV para usar como chaves do array associativo
            $header = fgetcsv($handle, 1000, ';');

            // remove colunas vazias
            $header = array_filter($header, fn($item) => $item !== '');
            $header = array_values($header);

            $header = array_map(fn($item) => trim(strtolower($item)), $header);

            // le cada linha do csv e transforma em um array associativo usando o cabeçalho como chaves
            while (($linha = fgetcsv($handle, 1000, ';')) !== false) {

                if (empty(array_filter($linha))) {
                    continue;
                }

                if (count($header) !== count($linha)) {
                    continue;
                }

                // Junta cabeçalho + valores
                $dadosCsv[] = array_combine($header, $linha);
            }

            fclose($handle);
        }


        return view('pagamentos.index', compact('dadosCsv'));
    }

    public function processarPagamentos(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $dados = json_decode($request->input('dados'), true);
        if (!$dados) {
            return redirect()->back()->with('error', 'Dados inválidos para processamento.');
        }

        $sucesso = 0;
        $falhas = 0;

        $falhasDetalhes = [];

        DB::beginTransaction();
        foreach ($dados as $linha) {
            $cpf = preg_replace('/\D/', '', $linha['cpf']);
            $associado = Associado::where('cpf', $cpf)->first();

            if (!$associado) {
                $falhas++;

                $falhasDetalhes[] = [
                    'cpf' =>  $cpf,
                    'nome' => $linha['nome'] ?? 'N/A',
                    'motivo' => 'Associado não encontrado'
                ];

                continue;
            }


            $valor = str_replace(',', '.', $linha['valor']);
            $valor = trim($valor);


            $data_pagamento = $request->input('data_pagamento') ? $request->input('data_pagamento') : now();
            $mesReferencia = Carbon::createFromFormat('m/Y', $linha['mes_referencia'])->startOfMonth();

            $existe = Pagamento::where('associado_id', $associado->id)
                ->where('mes_referencia', $mesReferencia)
                ->where('valor', $valor)
                ->exists();

            if ($existe) {
                $falhas++;

                $falhasDetalhes[] = [
                    'cpf' =>  $cpf,
                    'nome' => $linha['nome'] ?? 'N/A',
                    'motivo' => 'Pagamento já registrado para este mês de referência (mesmo valor e mês)'
                ];

                continue;
            }

            Pagamento::create([
                'associado_id'      => $associado->id,
                'user_id'           => $user->id,
                'valor'             => $valor,
                'mes_referencia'    => $mesReferencia,
                'data_pagamento'    => $data_pagamento,
                'metodo_pagamento'  => 'desconto_em_folha',
                'origem'            => 'importacao_csv',
                'observacao'        => $request->input('observacao') ?? null,
            ]);

            $sucesso++;
        }

        $falhasAgrupadas = [];

        foreach ($falhasDetalhes as $erro) {
            $motivo = $erro['motivo'];

            if (!isset($falhasAgrupadas[$motivo])) {
                $falhasAgrupadas[$motivo] = [];
            }

            $falhasAgrupadas[$motivo][] = $erro;
        }
        DB::commit();

        return redirect()->route('pagamentos.index')->with([
            'success' => 'Pagamentos processados com sucesso.',
            'sucesso' => $sucesso,
            'falhas' => $falhas,
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

        $request->validate([
            'valor' => 'required|string',
            'data_pagamento' => 'required|date',
            'mes_referencia' => 'required',
            'metodo_pagamento' => 'nullable|string|max:255',
            'tipo' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'numero_documento' => 'nullable|string|max:255',
            'origem' => 'nullable|string|max:255',
            'observacao' => 'nullable|string',
        ]);

        $valor = str_replace('.', '', $request->input('valor'));
        $valor = str_replace(',', '.', $request->input('valor'));
        $valor = trim($valor);

        $mesReferencia = Carbon::createFromFormat('Y-m', $request->input('mes_referencia'))->startOfMonth();

        $pagamento->update([
            'valor' => $valor,
            'data_pagamento' => $request->input('data_pagamento'),
            'mes_referencia' => $mesReferencia,
            'metodo_pagamento' => $request->input('metodo_pagamento'),
            'tipo' => $request->input('tipo'),
            'status' => $request->input('status'),
            'numero_documento' => $request->input('numero_documento'),
            'origem' => $request->input('origem'),
            'observacao' => $request->input('observacao'),
        ]);

        return redirect()->route('pagamentos.show', $pagamento->associado_id)->with('success', 'Pagamento atualizado com sucesso.');
    }
}
