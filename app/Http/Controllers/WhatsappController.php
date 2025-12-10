<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use App\Models\Situacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;


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
        $instancia = "AspraAdm";
        $token = "meu_token";

        $resultados = [];

        foreach ($numeros as $numero) {

            // USANDO O N8N:
            $response = Http::post('https://n8n.asprarn.com.br/webhook-test/776ee56a-3e3c-4e7b-81f1-fdc6dab2683b', [
                'numero'   => $numero,
                'mensagem' => $mensagem,
                'instancia' => $instancia
            ]);

            $resultados[] = [
                'numero' => $numero,
                'status' => $response->successful() ? 'enviado' : 'erro',
                'resposta' => $response->body()
            ];
        }

        return response()->json($resultados);
    }

    public function index()
    {
        // $user = Auth::user();

        // if (!$user || !$user->hasAnyRole(['admin', 'moderador'])) {
        //     return redirect()->back()->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        // }

        $associados = Associado::all();
        $situacoes = Situacao::all();

        return view('whatsapp.index', compact('associados', 'situacoes'));
    }
}
