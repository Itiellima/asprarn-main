<?php

namespace Tests\Feature;

use App\Models\FinanceiroCategoria;
use App\Models\FinanceiroLancamento;
use App\Services\Financeiro\LancamentoService;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinanceiroTest extends TestCase
{
    use RefreshDatabase;

    private LancamentoService $servico;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $this->actingAs($admin);

        $this->servico = app(LancamentoService::class);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    private function lancamento(array $dados = []): FinanceiroLancamento
    {
        return FinanceiroLancamento::create(array_merge([
            'tipo' => 'despesa',
            'valor' => 100,
            'data_lancamento' => '2026-10-01',
            'situacao' => 'pendente',
        ], $dados));
    }

    // ---------- Contas a pagar / a receber ----------

    public function test_conta_a_pagar_so_entra_no_saldo_depois_de_paga(): void
    {
        $this->post('/financeiro/contas-a-pagar', [
            'valor' => '500.00',
            'data_lancamento' => '2026-10-01',
            'data_vencimento' => '2026-10-10',
            'repeticao' => '',
            'descricao' => 'Aluguel',
        ])->assertRedirect(route('contas-a-pagar.index'));

        $conta = FinanceiroLancamento::firstOrFail();
        $this->assertSame('despesa', $conta->tipo);
        $this->assertSame('pendente', $conta->situacao);
        $this->assertSame('unica', $conta->repeticao);
        $this->assertSame(0.0, $this->servico->saldo());

        $this->put("/financeiro/contas-a-pagar/{$conta->id}/pagar", ['situacao' => '1', 'data_pagamento' => '2026-10-09'])
            ->assertSessionHas('success');

        $this->assertSame('pago', $conta->fresh()->situacao);
        $this->assertSame(-500.0, $this->servico->saldo());

        // Desmarcar o "pago" volta para pendente e sai do saldo
        $this->put("/financeiro/contas-a-pagar/{$conta->id}/pagar", ['data_pagamento' => '2026-10-09']);

        $this->assertSame('pendente', $conta->fresh()->situacao);
        $this->assertNull($conta->fresh()->data_pagamento);
        $this->assertSame(0.0, $this->servico->saldo());
    }

    public function test_conta_a_receber_recebida_soma_no_saldo(): void
    {
        $this->post('/financeiro/contas-a-receber', [
            'valor' => '300',
            'data_lancamento' => '2026-10-01',
        ]);

        $conta = FinanceiroLancamento::firstOrFail();
        $this->assertSame('receita', $conta->tipo);

        $this->put("/financeiro/contas-a-receber/{$conta->id}/receber", ['situacao' => '1', 'data_pagamento' => '2026-10-05']);

        $this->assertSame(300.0, $this->servico->saldo());
    }

    public function test_conta_cancelada_sai_do_saldo_e_nao_pode_ser_paga(): void
    {
        $conta = $this->lancamento(['situacao' => 'pago', 'data_pagamento' => '2026-10-02']);
        $this->assertSame(-100.0, $this->servico->saldo());

        $this->put("/financeiro/contas-a-pagar/{$conta->id}/cancelar-pagamento")->assertSessionHas('success');

        $this->assertSame('cancelado', $conta->fresh()->situacao);
        $this->assertSame(0.0, $this->servico->saldo());

        $this->put("/financeiro/contas-a-pagar/{$conta->id}/pagar", ['situacao' => '1', 'data_pagamento' => '2026-10-03'])
            ->assertSessionHas('error', 'Um lançamento cancelado não pode ser pago.');

        $this->assertSame('cancelado', $conta->fresh()->situacao);
    }

    public function test_pagar_exige_data(): void
    {
        $conta = $this->lancamento();

        $this->put("/financeiro/contas-a-pagar/{$conta->id}/pagar", ['situacao' => '1'])
            ->assertSessionHasErrors('data_pagamento');

        $this->assertSame('pendente', $conta->fresh()->situacao);
    }

    public function test_lista_mostra_pendentes_por_padrao_e_filtra_por_situacao(): void
    {
        $this->lancamento(['descricao' => 'Conta pendente']);
        $this->lancamento(['descricao' => 'Conta paga', 'situacao' => 'pago', 'data_pagamento' => '2026-10-02']);
        $this->lancamento(['descricao' => 'Receita qualquer', 'tipo' => 'receita']);

        $this->get('/financeiro/contas-a-pagar')
            ->assertOk()
            ->assertSee('Conta pendente')
            ->assertDontSee('Conta paga')
            ->assertDontSee('Receita qualquer');

        $this->get('/financeiro/contas-a-pagar?situacao=pago')
            ->assertOk()
            ->assertSee('Conta paga')
            ->assertDontSee('Conta pendente');

        $this->get('/financeiro/contas-a-pagar?situacao=todas')
            ->assertSee('Conta pendente')
            ->assertSee('Conta paga');
    }

    public function test_receita_nao_abre_em_contas_a_pagar(): void
    {
        $receita = $this->lancamento(['tipo' => 'receita']);

        $this->get("/financeiro/contas-a-pagar/{$receita->id}/edit")->assertNotFound();
        $this->get("/financeiro/contas-a-receber/{$receita->id}/edit")->assertOk();
    }

    public function test_formularios_de_contas_abrem(): void
    {
        $conta = $this->lancamento();

        $this->get('/financeiro/contas-a-pagar/create')->assertOk()->assertSee('Nova Conta a Pagar');
        $this->get("/financeiro/contas-a-pagar/{$conta->id}/edit")->assertOk()->assertSee('Marcar como pago');
        $this->get('/financeiro/contas-a-receber/create')->assertOk()->assertSee('Nova Conta a Receber');
    }

    // ---------- Saldo, painel e extrato ----------

    public function test_saldo_considera_so_pagos_e_ignora_transferencias(): void
    {
        $this->lancamento(['tipo' => 'receita', 'valor' => 1000, 'situacao' => 'pago', 'data_pagamento' => '2026-10-01']);
        $this->lancamento(['tipo' => 'despesa', 'valor' => 250.50, 'situacao' => 'pago', 'data_pagamento' => '2026-10-02']);
        $this->lancamento(['tipo' => 'despesa', 'valor' => 999, 'situacao' => 'pendente']);
        $this->lancamento(['tipo' => 'despesa', 'valor' => 999, 'situacao' => 'cancelado']);
        $this->lancamento(['tipo' => 'transferencia', 'valor' => 400, 'situacao' => 'pago', 'data_pagamento' => '2026-10-03']);

        $this->assertSame(749.5, $this->servico->saldo());
    }

    public function test_painel_mostra_saldo_e_totais_do_mes_pela_data_de_pagamento(): void
    {
        Carbon::setTestNow('2026-10-20 10:00:00');

        // Lançado em setembro, mas pago em outubro: conta em outubro
        $this->lancamento(['tipo' => 'receita', 'valor' => 800, 'data_lancamento' => '2026-09-15', 'situacao' => 'pago', 'data_pagamento' => '2026-10-05']);
        $this->lancamento(['tipo' => 'despesa', 'valor' => 300, 'situacao' => 'pago', 'data_pagamento' => '2026-10-06']);
        // Pago em setembro: entra no saldo, mas não nos totais de outubro
        $this->lancamento(['tipo' => 'receita', 'valor' => 50, 'situacao' => 'pago', 'data_pagamento' => '2026-09-30']);
        $this->lancamento(['tipo' => 'despesa', 'valor' => 120, 'descricao' => 'Luz a vencer', 'data_vencimento' => '2026-10-25']);

        $this->get('/financeiro')
            ->assertOk()
            ->assertViewHas('saldoAtual', 550.0)
            ->assertViewHas('receitasMes', 800.0)
            ->assertViewHas('despesasMes', 300.0)
            ->assertSee('Luz a vencer');
    }

    public function test_extrato_em_ordem_cronologica_com_saldo_anterior(): void
    {
        $this->lancamento(['tipo' => 'receita', 'valor' => 1000, 'situacao' => 'pago', 'data_pagamento' => '2026-09-20', 'descricao' => 'Antes do período']);
        $this->lancamento(['tipo' => 'despesa', 'valor' => 200, 'situacao' => 'pago', 'data_pagamento' => '2026-10-10', 'descricao' => 'Segunda']);
        $this->lancamento(['tipo' => 'receita', 'valor' => 50, 'situacao' => 'pago', 'data_pagamento' => '2026-10-02', 'descricao' => 'Primeira']);
        $this->lancamento(['tipo' => 'despesa', 'valor' => 70, 'situacao' => 'pendente', 'descricao' => 'Pendente não entra']);

        $resposta = $this->get('/financeiro/extrato?inicio=2026-10-01&fim=2026-10-31')->assertOk();

        $resposta->assertViewHas('saldoAnterior', 1000.0);
        $resposta->assertViewHas('saldoFinal', 850.0);
        $resposta->assertViewHas('movimentacoes', function ($movimentacoes) {
            return $movimentacoes->pluck('descricao')->all() === ['Primeira', 'Segunda']
                && $movimentacoes->pluck('saldo')->all() === [1050.0, 850.0];
        });
        $resposta->assertDontSee('Pendente não entra');
    }

    public function test_extrato_sem_filtro_mostra_o_mes_atual(): void
    {
        Carbon::setTestNow('2026-10-20 10:00:00');

        $this->lancamento(['tipo' => 'receita', 'valor' => 10, 'situacao' => 'pago', 'data_pagamento' => '2026-10-01', 'descricao' => 'Deste mês']);
        $this->lancamento(['tipo' => 'receita', 'valor' => 10, 'situacao' => 'pago', 'data_pagamento' => '2026-08-01', 'descricao' => 'Mês passado']);

        $this->get('/financeiro/extrato')
            ->assertOk()
            ->assertSee('Deste mês')
            ->assertDontSee('Mês passado');
    }

    // ---------- Lançamentos e categorias ----------

    public function test_lancamento_guarda_nome_da_categoria(): void
    {
        $categoria = FinanceiroCategoria::create(['nome' => 'Material de escritório', 'tipo' => 'despesa']);

        $this->post('/financeiro/lancamentos', [
            'tipo' => 'despesa',
            'valor' => '35.90',
            'data_lancamento' => '2026-10-01',
            'categoria_id' => $categoria->id,
        ])->assertRedirect(route('lancamentos.index'));

        $lancamento = FinanceiroLancamento::firstOrFail();
        $this->assertSame('Material de escritório', $lancamento->categoria_nome);

        // Editar sem mudar a categoria não apaga o nome
        $this->put("/financeiro/lancamentos/{$lancamento->id}", [
            'tipo' => 'despesa',
            'valor' => '40.00',
            'data_lancamento' => '2026-10-01',
            'categoria_id' => $categoria->id,
        ]);

        $this->assertSame('Material de escritório', $lancamento->fresh()->categoria_nome);
        $this->assertSame('40.00', $lancamento->fresh()->valor);
    }

    public function test_telas_de_lancamentos_abrem(): void
    {
        $lancamento = $this->lancamento(['descricao' => 'Compra de papel']);

        $this->get('/financeiro/lancamentos')->assertOk()->assertSee('Compra de papel');
        $this->get('/financeiro/lancamentos/create')->assertOk()->assertSee('Transferência');
        $this->get("/financeiro/lancamentos/{$lancamento->id}/edit")->assertOk()->assertSee('Marcar como pago / recebido');
    }

    public function test_categoria_e_criada_com_o_tipo_escolhido(): void
    {
        $this->get('/financeiro/categoria/create')->assertOk()->assertSee('value="despesa"', false);

        $this->post('/financeiro/categoria/criar', ['nome' => 'Aluguel', 'tipo' => 'despesa'])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('financeiro_categorias', ['nome' => 'Aluguel', 'tipo' => 'despesa']);
    }
}
