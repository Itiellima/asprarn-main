<?php

namespace Tests\Feature;

use App\Models\Associado;
use App\Models\DiretoriaFuncao;
use App\Models\Empresa;
use App\Models\Funcionario;
use App\Models\PrestadorDeServicoAutonomo;
use App\Models\Situacao;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ValidacoesCadastrosTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
        $this->actingAs($this->admin);
    }

    // ---------- Empresa ----------

    public function test_empresa_guarda_cnpj_e_telefone_sem_mascara(): void
    {
        $this->post('/empresas/store', ['nome' => 'Empresa A', 'cnpj' => '11.222.333/0001-81', 'telefone' => '(84) 3222-1111'])
            ->assertSessionHasNoErrors();

        $empresa = Empresa::first();
        $this->assertSame('11222333000181', $empresa->cnpj);
        $this->assertSame('8432221111', $empresa->telefone);
    }

    public function test_empresa_recusa_cnpj_repetido_mesmo_com_mascara_diferente(): void
    {
        Empresa::forceCreate(['nome' => 'Empresa A', 'cnpj' => '11222333000181']);

        $this->post('/empresas/store', ['nome' => 'Empresa B', 'cnpj' => '11.222.333/0001-81'])
            ->assertSessionHasErrors(['cnpj' => 'Já existe uma empresa com esse CNPJ cadastrado.']);

        $this->assertSame(1, Empresa::count());
    }

    public function test_empresa_recusa_cnpj_incompleto(): void
    {
        $this->post('/empresas/store', ['nome' => 'Empresa A', 'cnpj' => '11.222.333/0001'])
            ->assertSessionHasErrors(['cnpj' => 'O CNPJ deve conter exatamente 14 dígitos numéricos.']);
    }

    public function test_empresa_editada_mantendo_o_proprio_cnpj(): void
    {
        $empresa = Empresa::forceCreate(['nome' => 'Empresa A', 'cnpj' => '11222333000181']);

        $this->put("/empresas/update/{$empresa->id}", ['nome' => 'Empresa A Ltda', 'cnpj' => '11.222.333/0001-81'])
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success', 'Empresa atualizada com sucesso.');

        $this->assertSame('Empresa A Ltda', $empresa->fresh()->nome);
    }

    // ---------- Funcionário e prestador ----------

    public function test_funcionario_recusa_cpf_invalido(): void
    {
        $this->post('/funcionarios/store', ['nome' => 'Fulano', 'cpf' => '123.456.789-00'])
            ->assertSessionHasErrors(['cpf' => 'CPF inválido.']);

        $this->assertSame(0, Funcionario::count());
    }

    public function test_funcionario_editado_mantendo_o_proprio_cpf(): void
    {
        $funcionario = Funcionario::forceCreate(['nome' => 'Fulano', 'cpf' => '52998224725']);

        $this->put("/funcionarios/update/{$funcionario->id}", ['nome' => 'Fulano Editado', 'cpf' => '529.982.247-25'])
            ->assertSessionHasNoErrors();

        $this->assertSame('Fulano Editado', $funcionario->fresh()->nome);
    }

    public function test_prestador_guarda_cpf_sem_mascara(): void
    {
        $this->post('/prestador-de-servicos-autonomos/store', ['nome' => 'Prestador', 'cpf' => '529.982.247-25', 'telefone_1' => '(84) 99999-1234'])
            ->assertSessionHasNoErrors();

        $prestador = PrestadorDeServicoAutonomo::first();
        $this->assertSame('52998224725', $prestador->cpf);
        $this->assertSame('84999991234', $prestador->telefone_1);
    }

    public function test_prestador_recusa_cpf_repetido_com_e_sem_mascara(): void
    {
        PrestadorDeServicoAutonomo::forceCreate(['nome' => 'Prestador', 'cpf' => '52998224725']);

        $this->post('/prestador-de-servicos-autonomos/store', ['nome' => 'Outro', 'cpf' => '529.982.247-25'])
            ->assertSessionHasErrors(['cpf' => 'Já existe um prestador de serviços com esse CPF cadastrado.']);
    }

    public function test_prestador_recusa_cpf_invalido(): void
    {
        $this->post('/prestador-de-servicos-autonomos/store', ['nome' => 'Prestador', 'cpf' => '111.111.111-11'])
            ->assertSessionHasErrors(['cpf' => 'CPF inválido.']);
    }

    // ---------- Função da diretoria ----------

    public function test_funcao_com_descricao_longa_pode_ser_editada(): void
    {
        $descricao = 'Responsável pelas finanças e pela prestação de contas da associação';
        $funcao = DiretoriaFuncao::forceCreate(['nome' => 'Tesoureiro', 'descricao' => $descricao, 'status' => 'ativo']);

        $this->put("/diretoria/funcoes/update/{$funcao->id}", ['nome' => 'Tesoureiro Geral', 'descricao' => $descricao, 'status' => 'ativo'])
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success', 'Função atualizada com sucesso.');

        $this->assertSame('Tesoureiro Geral', $funcao->fresh()->nome);
    }

    public function test_cadastro_de_funcao_diz_funcao(): void
    {
        $this->post('/diretoria/funcoes/store', ['nome' => 'Secretário', 'descricao' => 'Atas', 'status' => 'ativo'])
            ->assertSessionHas('success', 'Nova função cadastrada com sucesso.');
    }

    // ---------- Situações do associado ----------

    public function test_situacoes_do_associado_sao_salvas(): void
    {
        $associado = Associado::forceCreate(['nome' => 'Fulano', 'cpf' => '52998224725']);
        $situacao = Situacao::create(['nome' => 'Ativo']);

        $this->post("/situacao/update/{$associado->id}", ['situacoes' => [$situacao->id]])
            ->assertSessionHasNoErrors();

        $this->assertTrue($associado->situacoes()->whereKey($situacao->id)->exists());
    }

    public function test_situacao_inexistente_vira_mensagem_e_nao_erro_500(): void
    {
        $associado = Associado::forceCreate(['nome' => 'Fulano', 'cpf' => '52998224725']);

        $this->post("/situacao/update/{$associado->id}", ['situacoes' => [999]])
            ->assertRedirect()
            ->assertSessionHasErrors(['situacoes.0' => 'Situação inválida.']);
    }
}
