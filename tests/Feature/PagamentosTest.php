<?php

namespace Tests\Feature;

use App\Models\Associado;
use App\Models\FinanceiroLancamento;
use App\Models\Pagamento;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PagamentosTest extends TestCase
{
    use RefreshDatabase;

    private Associado $associado;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $this->actingAs($admin);

        $this->associado = Associado::forceCreate(['nome' => 'José da Silva', 'cpf' => '01234567890']);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    private function formulario(array $dados = []): array
    {
        return array_merge([
            'valor' => '1.234,56',
            'data_pagamento' => '2026-10-05',
            'mes_referencia' => '2026-10',
            'metodo_pagamento' => 'pix',
            'tipo' => 'mensalidade',
            'status' => 'pago',
            'origem' => '',
        ], $dados);
    }

    // ---------- Pagamento manual ----------

    public function test_pagamento_manual_converte_valor_brasileiro_e_gera_receita(): void
    {
        $this->post("/pagamentos/store/{$this->associado->id}", $this->formulario())
            ->assertRedirect(route('pagamentos.show', $this->associado->id))
            ->assertSessionHasNoErrors();

        $pagamento = Pagamento::firstOrFail();
        $this->assertSame('1234.56', $pagamento->valor);
        $this->assertSame('2026-10-01', $pagamento->mes_referencia->toDateString());
        $this->assertSame('manual', $pagamento->origem);
        $this->assertSame('José da Silva', $pagamento->associado_nome);

        $receita = $pagamento->lancamento;
        $this->assertNotNull($receita);
        $this->assertSame('receita', $receita->tipo);
        $this->assertSame('1234.56', $receita->valor);
        $this->assertSame('pago', $receita->situacao);
        $this->assertSame('2026-10-05', $receita->data_pagamento->toDateString());
        $this->assertSame('Mensalidade', $receita->categoria_nome);
        $this->assertSame('Mensalidade 10/2026 - José da Silva', $receita->descricao);
    }

    public function test_editar_pagamento_sem_mudar_nada_nao_corrompe_o_valor(): void
    {
        $this->post("/pagamentos/store/{$this->associado->id}", $this->formulario());
        $pagamento = Pagamento::firstOrFail();

        // O formulário de edição mostra o valor como "1.234,56" (number_format) e reenvia assim
        $this->put("/pagamentos/update/{$pagamento->id}", $this->formulario([
            'valor' => number_format($pagamento->valor, 2, ',', '.'),
        ]))->assertSessionHasNoErrors();

        $this->assertSame('1234.56', $pagamento->fresh()->valor);
        $this->assertSame('1234.56', $pagamento->fresh()->lancamento->valor);
    }

    public function test_editar_pagamento_atualiza_a_receita(): void
    {
        $this->post("/pagamentos/store/{$this->associado->id}", $this->formulario());
        $pagamento = Pagamento::firstOrFail();

        $this->put("/pagamentos/update/{$pagamento->id}", $this->formulario(['valor' => '150,00', 'status' => 'pendente']));

        $receita = $pagamento->fresh()->lancamento;
        $this->assertSame('150.00', $receita->valor);
        $this->assertSame('pendente', $receita->situacao);
        $this->assertNull($receita->data_pagamento);
        $this->assertSame(1, FinanceiroLancamento::count());
    }

    public function test_excluir_pagamento_remove_a_receita(): void
    {
        $this->post("/pagamentos/store/{$this->associado->id}", $this->formulario());
        $pagamento = Pagamento::firstOrFail();

        $this->delete("/pagamentos/destroy/{$pagamento->id}")->assertSessionHas('success');

        $this->assertSame(0, Pagamento::count());
        $this->assertSame(0, FinanceiroLancamento::count());
    }

    public function test_nao_permite_dois_pagamentos_do_mesmo_tipo_no_mesmo_mes(): void
    {
        $this->post("/pagamentos/store/{$this->associado->id}", $this->formulario());

        $this->post("/pagamentos/store/{$this->associado->id}", $this->formulario(['valor' => '99,00']))
            ->assertSessionHasErrors('mes_referencia');

        $this->assertSame(1, Pagamento::count());

        // Anuidade no mesmo mês é outro tipo: pode
        $this->post("/pagamentos/store/{$this->associado->id}", $this->formulario(['tipo' => 'anuidade']))
            ->assertSessionHasNoErrors();
        $this->assertSame(2, Pagamento::count());
    }

    public function test_valor_invalido_e_recusado(): void
    {
        $this->post("/pagamentos/store/{$this->associado->id}", $this->formulario(['valor' => 'abc']))
            ->assertSessionHasErrors('valor');

        $this->assertSame(0, Pagamento::count());
    }

    public function test_receita_de_pagamento_nao_e_alterada_pelo_financeiro(): void
    {
        $this->post("/pagamentos/store/{$this->associado->id}", $this->formulario());
        $receita = FinanceiroLancamento::firstOrFail();

        $this->delete("/financeiro/lancamentos/{$receita->id}")->assertSessionHas('error');
        $this->put("/financeiro/lancamentos/{$receita->id}/cancelar-recebimento")->assertSessionHas('error');

        $this->assertSame('pago', $receita->fresh()->situacao);
        $this->get("/financeiro/lancamentos/{$receita->id}/edit")
            ->assertOk()
            ->assertSee('gerado por um pagamento de associado');
    }

    // ---------- Importação de CSV ----------

    private function csv(string $conteudo): UploadedFile
    {
        $caminho = tempnam(sys_get_temp_dir(), 'csv');
        file_put_contents($caminho, $conteudo);

        return new UploadedFile($caminho, 'pagamentos.csv', 'text/csv', null, true);
    }

    private function lerCsv(string $conteudo): array
    {
        $resposta = $this->post('/importar-pagamentos/read-archive', ['arquivo' => $this->csv($conteudo)])->assertOk();

        return $resposta->viewData('dadosCsv');
    }

    public function test_le_csv_do_excel_em_ansi_com_titulo_e_cabecalho_acentuado(): void
    {
        $conteudo = "Relatório de descontos;;;\n"
            . "Nome;CPF;Matrícula;Valor;Mês de Referência;\n"
            . "José da Silva;1234567890;123456;1.234,56;02/2026;\n";

        $dados = $this->lerCsv(mb_convert_encoding($conteudo, 'Windows-1252', 'UTF-8'));

        $this->assertCount(1, $dados);
        $this->assertSame('José da Silva', $dados[0]['nome']);
        $this->assertSame('123456', $dados[0]['matricula']);
        $this->assertSame('1.234,56', $dados[0]['valor']);
        $this->assertSame('02/2026', $dados[0]['mes_referencia']);
    }

    public function test_importacao_grava_valor_e_mes_corretos_mesmo_no_dia_31(): void
    {
        Carbon::setTestNow('2026-03-31 10:00:00');

        $dados = $this->lerCsv("nome;cpf;valor;mes_referencia\nJosé da Silva;1234567890;1.234,56;02/2026\n");

        $this->post('/importar-pagamentos/processar', [
            'dados' => json_encode($dados),
            'data_pagamento' => '2026-03-10',
        ])->assertRedirect(route('importar-pagamentos.index'))
            ->assertSessionHas('sucesso', 1)
            ->assertSessionHas('falhas', 0);

        $pagamento = Pagamento::firstOrFail();
        $this->assertSame($this->associado->id, $pagamento->associado_id);
        $this->assertSame('1234.56', $pagamento->valor);
        $this->assertSame('2026-02-01', $pagamento->mes_referencia->toDateString());
        $this->assertSame('importacao_csv', $pagamento->origem);

        $receita = $pagamento->lancamento;
        $this->assertSame('1234.56', $receita->valor);
        $this->assertSame('2026-03-10', $receita->data_pagamento->toDateString());
        $this->assertSame('2026-03-10', $receita->data_lancamento->toDateString());
    }

    public function test_linhas_invalidas_nao_cancelam_o_lote(): void
    {
        $dados = [
            ['nome' => 'José da Silva', 'cpf' => '012.345.678-90', 'valor' => '120,00', 'mes_referencia' => '10/2026'],
            ['nome' => 'Desconhecido', 'cpf' => '99999999999', 'valor' => '120,00', 'mes_referencia' => '10/2026'],
            ['nome' => 'José da Silva', 'cpf' => '01234567890', 'valor' => 'abc', 'mes_referencia' => '11/2026'],
            ['nome' => 'José da Silva', 'cpf' => '01234567890', 'valor' => '120,00', 'mes_referencia' => '13/2026'],
            ['nome' => 'Sem valor', 'cpf' => '01234567890'],
        ];

        $this->post('/importar-pagamentos/processar', ['dados' => json_encode($dados)])
            ->assertSessionHas('sucesso', 1)
            ->assertSessionHas('falhas', 4)
            ->assertSessionHas('falhasAgrupadas', function ($grupos) {
                return array_keys($grupos) == [
                    'Associado não encontrado',
                    'Valor inválido',
                    'Mês de referência inválido (use mm/aaaa)',
                    'Linha incompleta (faltam cpf, valor ou mes_referencia)',
                ];
            });

        $this->assertSame(1, Pagamento::count());
    }

    public function test_reimportar_o_mesmo_mes_nao_duplica_mesmo_com_valor_diferente(): void
    {
        $linha = ['nome' => 'José', 'cpf' => '01234567890', 'valor' => '120,00', 'mes_referencia' => '10/2026'];

        $this->post('/importar-pagamentos/processar', ['dados' => json_encode([$linha])]);
        $this->post('/importar-pagamentos/processar', ['dados' => json_encode([array_merge($linha, ['valor' => '125,00'])])])
            ->assertSessionHas('sucesso', 0)
            ->assertSessionHas('falhas', 1);

        $this->assertSame(1, Pagamento::count());
        $this->assertSame(1, FinanceiroLancamento::count());
        $this->assertSame('120.00', Pagamento::first()->valor);
    }
}
