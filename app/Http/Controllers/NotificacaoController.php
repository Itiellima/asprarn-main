<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NotificacaoController extends Controller
{
    //
    public function enviarNotificacaoNovoAssociado($request)
    {
        $response = Http::post('https://n8n.asprarn.com.br/webhook/aecf6a29-0e3a-4973-a8f6-b46c178836cc', [
            'nome' => $request->nome,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'acao' => 'novo_associado',
            'mensagem' => 'Um novo associado foi registrado no sistema.',
            'from' => $request->tel_celular,
            'instance' => 'AspraAdm',
        ]);
        
        // Lógica para enviar notificação de novo associado
        return $response->body();
    }
}
