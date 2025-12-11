<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Automacao;
use Carbon\Carbon;
use App\Models\Associado;

class ExecutarAutomacoes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:executar-automacoes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $agora = Carbon::now()->startOfMinute();

        $automacoes = Automacao::where('ativa', true)->get();

        foreach ($automacoes as $automacao) {

            // Verifica se a data de início é igual ao momento atual
            if (!$automacao->data_inicio->equalTo($agora)) {
                continue;
            }

            $destinatarios = Associado::where('situacao_id', $automacao->situacao_id)->get();

            foreach ($destinatarios as $destinatario) {
                Http::post('https://n8n.asprarn.com.br/webhook-test/776ee56a-3e3c-4e7b-81f1-fdc6dab2683b', [
                    'numero'   => $destinatario->contsto->tel_celular,
                    'mensagem' => $automacao->mensagem,
                    'instancia' => 'AspraAdm'
                ]);
            }

            if ($automacao->intervalo_dias > 0) {
                $automacao->data_inicio = Carbon::parse($automacao->data_inicio)->addDays($automacao->intervalo_dias);
                $automacao->save();
            }
        }
        return Command::SUCCESS;
    }
}
