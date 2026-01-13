<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Event;
use App\Events\NotificacaoCriada;
use App\Listeners\ProcessarNotificacao;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Apenas se não estiver no ambiente local
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
