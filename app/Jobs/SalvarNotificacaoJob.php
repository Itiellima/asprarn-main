<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Notificacao;

class SalvarNotificacaoJob implements ShouldQueue
{
    use Queueable;

    protected int $tries = 3;
    protected int $timeout = 30;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Lógica para salvar a notificação no banco de dados
        // Notificacao::create([
        //     'titulo' => $this->data['titulo'] ?? 'null',
        //     'mensagem' => $this->data['mensagem'] ?? null,
        //     'associado_id' => $this->data['associado_id'] ?? null,
        //     'lida' => false,
        // ]);

    }
}
