<?php

namespace Tests\Feature;

use App\Models\Associado;
use App\Models\Automacao;
use App\Models\Situacao;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutomacaoApiTest extends TestCase
{
    use RefreshDatabase;

    private const TOKEN = 'token-de-teste';

    protected function setUp(): void
    {
        parent::setUp();

        config(['services.n8n.token' => self::TOKEN]);
    }

    private function criarAutomacaoComAssociado(): Automacao
    {
        $situacao = Situacao::forceCreate(['nome' => 'Ativo']);

        $associado = Associado::forceCreate(['nome' => 'Fulano de Tal', 'cpf' => '12345678900']);
        $associado->situacoes()->attach($situacao->id);

        return Automacao::forceCreate([
            'nome' => 'Lembrete',
            'mensagem' => 'Olá!',
            'data_inicio' => now()->subDay()->toDateString(),
            'intervalo_dias' => 30,
            'ativo' => true,
            'situacao_id' => $situacao->id,
        ]);
    }

    public function test_endpoints_recusam_requisicao_sem_token(): void
    {
        $this->criarAutomacaoComAssociado();

        foreach (['/api/automacoes/executar', '/api/automacoes/test'] as $url) {
            $this->getJson($url)->assertUnauthorized()->assertDontSee('Fulano');
            $this->postJson($url)->assertUnauthorized()->assertDontSee('Fulano');
        }
    }

    public function test_endpoints_recusam_token_invalido(): void
    {
        $this->postJson('/api/automacoes/executar', [], ['x-api-key' => 'errado'])
            ->assertUnauthorized();
    }

    public function test_endpoints_ficam_fechados_sem_token_configurado(): void
    {
        config(['services.n8n.token' => null]);

        $this->postJson('/api/automacoes/executar', [], ['x-api-key' => ''])
            ->assertUnauthorized();
    }

    public function test_executar_com_token_valido_retorna_destinatarios_e_grava_execucao(): void
    {
        $automacao = $this->criarAutomacaoComAssociado();

        $this->postJson('/api/automacoes/executar', [], ['x-api-key' => self::TOKEN])
            ->assertOk()
            ->assertJsonPath('resultados.0.associados.0', 'Fulano de Tal');

        $this->assertNotNull($automacao->fresh()->ultima_execucao);
    }

    public function test_simulacao_nao_bloqueia_o_envio_real(): void
    {
        $automacao = $this->criarAutomacaoComAssociado();

        $this->postJson('/api/automacoes/test', [], ['x-api-key' => self::TOKEN])
            ->assertOk()
            ->assertJsonPath('resultados.0.associados.0', 'Fulano de Tal');

        $this->assertNull($automacao->fresh()->ultima_execucao);

        // O envio real do dia continua acontecendo depois da simulação
        $this->postJson('/api/automacoes/executar', [], ['x-api-key' => self::TOKEN])
            ->assertOk()
            ->assertJsonCount(1, 'resultados');
    }
}
