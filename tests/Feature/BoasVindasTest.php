<?php

namespace Tests\Feature;

use App\Events\AssociadoCriado;
use App\Listeners\EnviarEmailBoasVindas;
use App\Models\Associado;
use Illuminate\Events\CallQueuedListener;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class BoasVindasTest extends TestCase
{
    use RefreshDatabase;

    private function associado(): Associado
    {
        $associado = Associado::forceCreate(['nome' => 'Fulano', 'cpf' => '11111111111']);
        $associado->contato()->create(['email' => 'fulano@exemplo.com']);

        return $associado;
    }

    public function test_boas_vindas_vai_para_a_fila_em_vez_de_rodar_no_cadastro(): void
    {
        Queue::fake();
        Http::fake();

        event(new AssociadoCriado($this->associado()));

        Queue::assertPushed(CallQueuedListener::class, fn ($job) => $job->class === EnviarEmailBoasVindas::class);
        Http::assertNothingSent();
    }

    public function test_envia_o_associado_para_o_n8n_com_a_chave(): void
    {
        config(['services.n8n.token' => 'chave-n8n']);
        Http::fake();

        $associado = $this->associado();
        (new EnviarEmailBoasVindas)->handle(new AssociadoCriado($associado));

        Http::assertSent(fn ($request) => $request->hasHeader('x-api-key', 'chave-n8n')
            && $request['evento'] === 'associado_criado'
            && $request['email'] === 'fulano@exemplo.com');
    }

    public function test_erro_do_n8n_falha_o_job_para_tentar_de_novo(): void
    {
        Http::fake(['*' => Http::response('erro', 500)]);

        $this->expectException(RequestException::class);

        (new EnviarEmailBoasVindas)->handle(new AssociadoCriado($this->associado()));
    }
}
