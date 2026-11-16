<?php

namespace Tests\Feature;

use App\Helpers\CpfHelper;
use App\Models\Associado;
use App\Models\Pagamento;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PainelAssociadoTest extends TestCase
{
    use RefreshDatabase;

    private Associado $associado;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        $this->associado = Associado::forceCreate(['nome' => 'Fulano de Tal', 'cpf' => '52998224725']);

        $login = User::factory()->create(['associado_id' => $this->associado->id]);
        $login->assignRole('associado');
        $this->actingAs($login);
    }

    public function test_sem_data_de_nascimento_mostra_nao_informada(): void
    {
        // Antes, Carbon::parse(null) mostrava a data de hoje
        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('Não informada')
            ->assertDontSee(now()->format('d/m/Y'));
    }

    public function test_mostra_data_de_nascimento_e_cpf_formatados(): void
    {
        $this->associado->forceFill(['dt_nasc' => '1990-05-20'])->save();

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('20/05/1990')
            ->assertSee('529.982.247-25');
    }

    public function test_sem_pagamentos_mostra_aviso(): void
    {
        $this->get('/dashboard')->assertOk()->assertSee('Nenhum pagamento registrado ainda.');
    }

    public function test_pagamento_sem_mes_de_referencia_nao_quebra_o_painel(): void
    {
        Pagamento::forceCreate([
            'associado_id' => $this->associado->id,
            'valor' => '72.30',
            'data_pagamento' => '2026-10-05',
            'mes_referencia' => null,
        ]);

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('R$ 72,30')
            ->assertSee('05/10/2026');
    }

    public function test_tela_de_exemplo_de_pagamento_foi_removida(): void
    {
        $this->get('/associado/financeiro')->assertNotFound();
    }

    public function test_formatar_cpf(): void
    {
        $this->assertSame('529.982.247-25', CpfHelper::formatar('52998224725'));
        $this->assertSame('529.982.247-25', CpfHelper::formatar('529.982.247-25'));
        // Valor fora do padrão volta como está, sem inventar formato
        $this->assertSame('123', CpfHelper::formatar('123'));
    }
}
