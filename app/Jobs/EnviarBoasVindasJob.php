<?php

namespace App\Jobs;

use App\Mail\AssociadoBoasVindasMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Associado;
use Illuminate\Support\Facades\Http;

class EnviarBoasVindasJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public Associado $associado;

    /**
     * Create a new job instance.
     */
    public function __construct(Associado $associado)
    {
        $this->associado = $associado;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Http::post('https://n8n.asprarn.com.br/webhook/a58b3e96-1779-440e-9c5d-256710e691a3', [
            'nome' => $this->associado->nome,
            'email' => $this->associado->contato?->email,
            'msg' => 'Olá, Bem-vindo à ASPRARN! Esta é uma mensagem de boas-vindas para confirmar que sua associação foi criada com sucesso. Se você tiver alguma dúvida ou precisar de assistência, não hesite em entrar em contato conosco.',
        ]);
    }
}
