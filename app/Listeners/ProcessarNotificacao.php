<?php

namespace App\Listeners;

use App\Events\NotificacaoCriada;
use App\Models\Notificacao;

class ProcessarNotificacao
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
    public function handle(NotificacaoCriada $event): void
    {
        Notificacao::create([
            'titulo' => $event->data['titulo'],
            'mensagem' => $event->data['mensagem'],
            'associado_id' => $event->data['associado_id'],
            'lida' => false,
        ]);
    }
}
