<?php

namespace Tests\Feature;

use App\Helpers\CpfHelper;
use App\Models\AcaoJudicial;
use App\Models\Associado;
use App\Models\HistoricoSituacoes;
use App\Models\Pagamento;
use App\Models\Situacao;
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

    public function test_mostra_as_acoes_judiciais_do_associado(): void
    {
        $acao = AcaoJudicial::create([
            'nome' => 'Ação do piso salarial',
            'descricao' => 'Reajuste do piso de 2025',
            'status' => 'Em andamento',
            'data_inicio' => '2026-03-10',
        ]);
        $acao->associados()->attach($this->associado->id);

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('Ação do piso salarial')
            ->assertSee('Reajuste do piso de 2025')
            ->assertSee('Em andamento')
            ->assertSee('10/03/2026');
    }

    public function test_nao_mostra_acao_judicial_de_outro_associado(): void
    {
        $outro = Associado::forceCreate(['nome' => 'Outro', 'cpf' => '11144477735']);
        $acao = AcaoJudicial::create(['nome' => 'Ação de outra pessoa']);
        $acao->associados()->attach($outro->id);

        $this->get('/dashboard')
            ->assertOk()
            ->assertDontSee('Ação de outra pessoa')
            ->assertSee('Você não está incluído em nenhuma ação judicial.');
    }

    public function test_mostra_situacao_atual_e_historico_sem_a_observacao(): void
    {
        $situacao = Situacao::create(['nome' => 'Em dia']);
        $this->associado->situacoes()->attach($situacao->id);

        HistoricoSituacoes::create([
            'associado_id' => $this->associado->id,
            'situacao' => 'Licença médica',
            'observacao' => 'Anotação interna da diretoria',
            'data_inicio' => '2025-01-15',
            'data_fim' => '2025-06-30',
        ]);

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('Em dia')
            ->assertSee('Licença médica')
            ->assertSee('15/01/2025')
            ->assertSee('30/06/2025')
            ->assertDontSee('Anotação interna da diretoria');
    }

    public function test_sem_situacao_mostra_aviso(): void
    {
        $this->get('/dashboard')->assertOk()->assertSee('Nenhuma situação registrada.');
    }

    public function test_formatar_cpf(): void
    {
        $this->assertSame('529.982.247-25', CpfHelper::formatar('52998224725'));
        $this->assertSame('529.982.247-25', CpfHelper::formatar('529.982.247-25'));
        // Valor fora do padrão volta como está, sem inventar formato
        $this->assertSame('123', CpfHelper::formatar('123'));
    }
}
