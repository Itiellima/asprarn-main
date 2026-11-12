<?php

namespace Tests\Feature;

use App\Models\Plano;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanosTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        $financeiro = User::factory()->create();
        $financeiro->assignRole('financeiro');
        $this->actingAs($financeiro);
    }

    private function dados(array $extra = []): array
    {
        return array_merge([
            'nome' => 'Plano Básico',
            'beneficios' => ['Assessoria jurídica', 'Convênio médico'],
            'descricao' => 'Plano de entrada',
            'preco' => '1.234,56',
        ], $extra);
    }

    private function plano(): Plano
    {
        return Plano::create([
            'nome' => 'Plano Básico',
            'beneficios' => ['Assessoria jurídica'],
            'descricao' => 'Plano de entrada',
            'preco' => '50.00',
        ]);
    }

    public function test_cria_plano_com_valor_mascarado_e_varios_beneficios(): void
    {
        // Antes, a coluna VARCHAR(255) estourava com poucos benefícios acentuados
        $beneficios = array_fill(0, 5, trim(str_repeat('Benefício com acentuação ', 10)));

        $this->post('/planos/store', $this->dados(['beneficios' => $beneficios]))
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('planos.index'))
            ->assertSessionHas('success', 'Plano criado com sucesso!');

        $plano = Plano::first();
        $this->assertSame('1234.56', $plano->preco);
        $this->assertSame($beneficios, $plano->beneficios);
    }

    public function test_atualiza_plano_com_valor_mascarado(): void
    {
        $plano = $this->plano();

        $this->put("/planos/update/{$plano->id}", $this->dados(['preco' => '150,00']))
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('planos.index'));

        $this->assertSame('150.00', $plano->fresh()->preco);
    }

    public function test_atualiza_plano_sem_mexer_no_valor(): void
    {
        // Valor sem vírgula (como vem do banco) continua aceito
        $plano = $this->plano();

        $this->put("/planos/update/{$plano->id}", $this->dados(['preco' => '50.00']))
            ->assertSessionHasNoErrors();

        $this->assertSame('50.00', $plano->fresh()->preco);
    }

    public function test_recusa_valor_invalido(): void
    {
        $this->post('/planos/store', $this->dados(['preco' => 'abc']))
            ->assertSessionHasErrors(['preco' => 'Informe um valor válido.']);

        $this->assertSame(0, Plano::count());
    }

    public function test_recusa_plano_sem_beneficios(): void
    {
        $this->post('/planos/store', $this->dados(['beneficios' => []]))
            ->assertSessionHasErrors(['beneficios' => 'Informe pelo menos um benefício.']);
    }

    public function test_tela_de_edicao_mostra_valor_formatado_e_beneficios(): void
    {
        $plano = $this->plano();

        $this->get("/planos/edit/{$plano->id}")
            ->assertOk()
            ->assertSee('EDITAR PLANO')
            ->assertSee('value="50,00"', false)
            ->assertSee('Assessoria jurídica');
    }
}
