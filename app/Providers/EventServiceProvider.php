<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\NotificacaoCriada;
use App\Listeners\ProcessarNotificacao;
use App\Events\AssociadoCriado;
use App\Listeners\EnviarEmailBoasVindas;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        NotificacaoCriada::class => [
            ProcessarNotificacao::class,
        ],

        AssociadoCriado::class => [
            EnviarEmailBoasVindas::class,
        ],
    ];



    public function boot(): void
    {
        //
    }
}
