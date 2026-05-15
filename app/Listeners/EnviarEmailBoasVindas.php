<?php

namespace App\Listeners;

use App\Events\AssociadoCriado;
use Illuminate\Support\Facades\Http;

class EnviarEmailBoasVindas
{

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AssociadoCriado $event): void
    {

        Http::withHeaders([
            'x-api-key' => env('N8N_API_KEY'),
        ])->post('https://n8n.asprarn.com.br/webhook/a58b3e96-1779-440e-9c5d-256710e691a3', [
            'nome' => $event->associado->nome,
            'email' => $event->associado->contato?->email,
            'msg' => 'Olá, Bem-vindo à ASPRARN! Esta é uma mensagem de boas-vindas para confirmar que sua associação foi criada com sucesso. Se você tiver alguma dúvida ou precisar de assistência, não hesite em entrar em contato conosco.',
        ]);
    }
}
