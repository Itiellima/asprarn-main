<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class WhatsappController extends Controller
{
    //

    public function enviarMensagens(Request $request)
    {
        // Validação
        $request->validate([
            'numeros' => 'required|array',
            'mensagem' => 'required|string',
            'nome' => 'required|string',
        ]);

        $numeros = $request->numeros;       // array de celulares
        $mensagem = $request->mensagem;     // texto da mensagem
        $instancia = "AspraAdm";     // coloque a sua
        $token = "meu_token";               // coloque o seu

        $resultados = [];

        foreach ($numeros as $numero) {

            // SE VOCÊ ESTIVER USANDO O N8N COMO INTERMEDIÁRIO:
            $response = Http::post('https://n8n.asprarn.com.br/webhook-test/776ee56a-3e3c-4e7b-81f1-fdc6dab2683b', [
                'numero'   => $numero,
                'mensagem' => $mensagem,
                'instancia' => $instancia
            ]);

            // DIRETO PARA EVOLUTION API, USE ISSO:
            /*
            $response = Http::post("https://sua-url-da-evolution/{$instancia}/message/sendText", [
                "phone" => $numero,
                "message" => $mensagem,
            ]);
            */

            $resultados[] = [
                'numero' => $numero,
                'status' => $response->successful() ? 'enviado' : 'erro',
                'resposta' => $response->body()
            ];
        }

        return response()->json($resultados);
    }
}
