<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Registra os comandos personalizados
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Define as tarefas agendadas
     */
    protected function schedule(Schedule $schedule)
    {
        // 🧹 Executa semanalmente a limpeza de pastas vazias
        $schedule->command('app:clean-empty-folders')->daily();
    }
}
