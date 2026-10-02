<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Remove diariamente as pastas vazias do disco public
Schedule::command('app:clean-empty-folders')->daily();

// As automações de WhatsApp são disparadas pelo n8n via /api/automacoes/executar
