<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\NotificacaoCriada;
use App\Listeners\ProcessarNotificacao;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        NotificacaoCriada::class => [
            ProcessarNotificacao::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
