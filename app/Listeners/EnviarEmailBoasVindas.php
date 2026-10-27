<?php

namespace App\Listeners;

use App\Events\AssociadoCriado;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;

// Roda na fila: o cadastro não espera o n8n e não mostra erro se ele estiver
// fora do ar. Se o envio falhar, o worker tenta de novo mais tarde.
class EnviarEmailBoasVindas implements ShouldQueue
{
    public int $tries = 5;

    // Espera entre as tentativas: 1 min, 5 min, 15 min, 1 h
    public array $backoff = [60, 300, 900, 3600];

    public function handle(AssociadoCriado $event): void
    {
        Http::timeout(15)
            ->withHeaders([
                'x-api-key' => config('services.n8n.token'),
            ])
            ->post('https://n8n.asprarn.com.br/webhook/e7d3cda2-bc0f-4b21-a46d-def676506122', [
                'evento' => 'associado_criado',
                'nome' => $event->associado->nome,
                'email' => $event->associado->contato?->email,
                'msg' => 'Olá, Bem-vindo à ASPRARN! Esta é uma mensagem de boas-vindas para confirmar que sua associação foi criada com sucesso. Se você tiver alguma dúvida ou precisar de assistência, não hesite em entrar em contato conosco.',
            ])
            // Resposta de erro do n8n também conta como falha, para tentar de novo
            ->throw();
    }
}
