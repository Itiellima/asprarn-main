<?php

namespace Tests\Feature;

use App\Models\Associado;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class AssociadoEdicaoTest extends TestCase
{
    use RefreshDatabase;

    private User $moderador;
    private Associado $associado;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        $this->moderador = User::factory()->create();
        $this->moderador->assignRole('moderador');

        $this->associado = Associado::forceCreate(['nome' => 'Fulano de Tal', 'cpf' => '52998224725']);
    }

    private function atualizar(array $dados)
    {
        return $this->actingAs($this->moderador)
            ->put("/associado/update/{$this->associado->id}", $dados + ['nome' => 'Fulano de Tal', 'cpf' => '52998224725']);
    }

    // ---------- Validação da edição ----------

    public function test_edicao_salva_e_guarda_o_cpf_e_telefone_sem_mascara(): void
    {
        $this->atualizar(['nome' => 'Fulano Editado', 'cpf' => '529.982.247-25', 'tel_celular' => '(84) 99999-1234'])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('associado.show', $this->associado->id));

        $this->associado->refresh();
        $this->assertSame('Fulano Editado', $this->associado->nome);
        $this->assertSame('52998224725', $this->associado->cpf);
        $this->assertSame('84999991234', $this->associado->contato->tel_celular);
    }

    public function test_edicao_mantendo_o_proprio_cpf_nao_acusa_duplicidade(): void
    {
        $this->atualizar(['obs' => 'Só a observação mudou'])->assertSessionHasNoErrors();

        $this->assertSame('Só a observação mudou', $this->associado->fresh()->obs);
    }

    public function test_edicao_recusa_cpf_invalido(): void
    {
        $this->atualizar(['cpf' => '123.456.789-00'])
            ->assertSessionHasErrors(['cpf' => 'CPF inválido.']);

        $this->assertSame('52998224725', $this->associado->fresh()->cpf);
    }

    public function test_edicao_recusa_cpf_de_outro_associado(): void
    {
        Associado::forceCreate(['nome' => 'Outro', 'cpf' => '11144477735']);

        $this->atualizar(['cpf' => '111.444.777-35'])
            ->assertSessionHasErrors(['cpf' => 'Já existe um associado cadastrado com esse CPF.']);

        $this->assertSame('52998224725', $this->associado->fresh()->cpf);
    }

    public function test_edicao_recusa_nome_e_cpf_vazios(): void
    {
        $this->atualizar(['nome' => '', 'cpf' => ''])
            ->assertSessionHasErrors(['nome', 'cpf']);

        $this->assertSame('Fulano de Tal', $this->associado->fresh()->nome);
    }

    // ---------- Cadastro (mesmas regras de CPF) ----------

    public function test_cadastro_recusa_cpf_invalido_como_erro_do_campo(): void
    {
        $this->post('/associado/store', ['nome' => 'Novo', 'cpf' => '111.111.111-11', 'email' => 'novo@exemplo.com'])
            ->assertSessionHasErrors(['cpf' => 'CPF inválido.']);

        $this->assertDatabaseMissing('users', ['email' => 'novo@exemplo.com']);
    }

    // ---------- AssociadoPolicy ----------

    private function usuario(string $perfil, ?int $associadoId = null): User
    {
        $user = User::factory()->create(['associado_id' => $associadoId]);
        $user->assignRole($perfil);

        return $user;
    }

    public function test_policy_associado_ve_e_altera_so_o_proprio_cadastro(): void
    {
        $outro = Associado::forceCreate(['nome' => 'Outro', 'cpf' => '11144477735']);
        $dono = $this->usuario('associado', $this->associado->id);

        $this->assertTrue(Gate::forUser($dono)->allows('view', $this->associado));
        $this->assertTrue(Gate::forUser($dono)->allows('alterarFoto', $this->associado));
        $this->assertFalse(Gate::forUser($dono)->allows('view', $outro));
        $this->assertFalse(Gate::forUser($dono)->allows('alterarFoto', $outro));
    }

    public function test_policy_admin_e_moderador_acessam_qualquer_associado(): void
    {
        $this->assertTrue(Gate::forUser($this->moderador)->allows('view', $this->associado));
        $this->assertTrue(Gate::forUser($this->usuario('admin'))->allows('alterarFoto', $this->associado));
    }

    public function test_policy_financeiro_e_user_sem_vinculo_nao_acessam(): void
    {
        $this->assertFalse(Gate::forUser($this->usuario('financeiro'))->allows('view', $this->associado));
        $this->assertFalse(Gate::forUser($this->usuario('user'))->allows('view', $this->associado));
    }

    public function test_associado_abre_as_proprias_paginas_e_a_verificacao_e_publica(): void
    {
        $dono = $this->usuario('associado', $this->associado->id);

        $this->actingAs($dono)->get("/asssociado/informacoes/{$this->associado->id}")->assertOk();
        $this->actingAs($dono)->get("/carteira-associados/{$this->associado->id}")->assertOk();
        $this->actingAs($dono)->get("/carteira-associados1/{$this->associado->id}")->assertOk();

        auth()->logout();
        $this->get("/carteira-associado-verificacao/{$this->associado->id}")->assertOk();
    }

    public function test_policy_perfil_associado_com_vinculo_de_outro_nao_acessa(): void
    {
        // O perfil sozinho não basta: o associado_id precisa ser o mesmo
        $semVinculo = $this->usuario('associado');

        $this->assertFalse(Gate::forUser($semVinculo)->allows('view', $this->associado));
    }
}
