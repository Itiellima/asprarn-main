<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Lógica para processar os pagamentos
        // Recebe os dados do formulário e processa os pagamentos conforme necessário

        $cpf = $request->input('cpf');

        foreach ($cpf as $cpfAssociado) {
            // Lógica para processar o pagamento do associado com o CPF $cpfAssociado
            // Exemplo: Atualizar o status de pagamento no banco de dados, enviar notificações, etc.
            

        }





        return redirect()->route('pagamentos.index')->with('success', 'Pagamentos processados com sucesso.');
    }
}
