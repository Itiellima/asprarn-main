<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Remove diariamente as pastas vazias do disco public
Schedule::command('app:clean-empty-folders')->daily();

// Executa a automação de envio de mensagens via WhatsApp a cada minuto
Schedule::command('app:executar-automacoes')->everyMinute();
