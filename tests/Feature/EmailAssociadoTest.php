<?php

namespace Tests\Feature;

use App\Models\Associado;
use App\Models\Contato;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * O e-mail fica em dois lugares: users.email (login, recuperação de senha) e
 * contatos.email (ficha, documentos, boas-vindas). As duas telas que o alteram
 * mantêm as cópias iguais.
 */
class EmailAssociadoTest extends TestCase
{
    use RefreshDatabase;

    private User $moderador;
    private Associado $associado;
    private User $login;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        $this->moderador = User::factory()->create();
        $this->moderador->assignRole('moderador');

        $this->associado = Associado::forceCreate(['nome' => 'Fulano de Tal', 'cpf' => '52998224725']);
        Contato::forceCreate(['associado_id' => $this->associado->id, 'email' => 'antigo@exemplo.com']);

        $this->login = User::factory()->create(['email' => 'antigo@exemplo.com', 'associado_id' => $this->associado->id]);
        $this->login->assignRole('associado');
    }

    private function editarFicha(array $dados)
    {
        return $this->actingAs($this->moderador)
            ->put("/associado/update/{$this->associado->id}", $dados + ['nome' => 'Fulano de Tal', 'cpf' => '52998224725']);
    }

    // ---------- Edição pelo painel ----------

    public function test_editar_o_email_da_ficha_altera_o_login(): void
    {
        $this->editarFicha(['email' => 'novo@exemplo.com'])
            ->assertSessionHasNoErrors()
            ->assertSessionHas('msg', 'Associado alterado com sucesso! O e-mail de login também foi alterado.');

        $this->assertSame('novo@exemplo.com', $this->login->fresh()->email);
        $this->assertSame('novo@exemplo.com', $this->associado->contato->fresh()->email);

        // O associado entra com o e-mail novo (senha da factory: "password")
        auth()->logout();
        $this->post('/login', ['email' => 'novo@exemplo.com', 'password' => 'password']);
        $this->assertAuthenticatedAs($this->login->fresh());
    }

    public function test_manter_o_email_nao_avisa_troca_de_login(): void
    {
        $this->editarFicha(['email' => 'antigo@exemplo.com'])
            ->assertSessionHas('msg', 'Associado alterado com sucesso!');
    }

    public function test_email_que_e_login_de_outro_usuario_e_recusado(): void
    {
        User::factory()->create(['email' => 'ocupado@exemplo.com']);

        $this->editarFicha(['email' => 'ocupado@exemplo.com'])
            ->assertSessionHasErrors(['email' => 'Este e-mail já é o login de outro usuário.']);

        $this->assertSame('antigo@exemplo.com', $this->login->fresh()->email);
        $this->assertSame('antigo@exemplo.com', $this->associado->contato->fresh()->email);
    }

    public function test_email_invalido_e_recusado(): void
    {
        $this->editarFicha(['email' => 'sem-arroba'])
            ->assertSessionHasErrors(['email' => 'Informe um e-mail válido.']);
    }

    public function test_email_vazio_nao_apaga_o_login(): void
    {
        $this->editarFicha(['email' => ''])->assertSessionHasNoErrors();

        $this->assertSame('antigo@exemplo.com', $this->login->fresh()->email);
    }

    public function test_associado_sem_usuario_pode_ter_o_email_editado(): void
    {
        $this->login->delete();

        $this->editarFicha(['email' => 'novo@exemplo.com'])
            ->assertSessionHasNoErrors()
            ->assertSessionHas('msg', 'Associado alterado com sucesso!');

        $this->assertSame('novo@exemplo.com', $this->associado->contato->fresh()->email);
    }

    // ---------- Perfil (/profile) ----------

    public function test_trocar_o_email_no_perfil_atualiza_a_ficha(): void
    {
        $this->actingAs($this->login);

        Livewire::test(UpdateProfileInformationForm::class)
            ->set('state', ['name' => $this->login->name, 'email' => 'perfil@exemplo.com'])
            ->call('updateProfileInformation');

        $this->assertSame('perfil@exemplo.com', $this->login->fresh()->email);
        $this->assertSame('perfil@exemplo.com', $this->associado->contato->fresh()->email);
    }

    public function test_perfil_de_usuario_sem_associado_continua_funcionando(): void
    {
        $this->actingAs($this->moderador);

        Livewire::test(UpdateProfileInformationForm::class)
            ->set('state', ['name' => 'Moderador', 'email' => 'moderador@exemplo.com'])
            ->call('updateProfileInformation')
            ->assertHasNoErrors();

        $this->assertSame('moderador@exemplo.com', $this->moderador->fresh()->email);
    }

    // ---------- Cadastro ----------

    public function test_cadastro_recusa_email_invalido(): void
    {
        $this->post('/associado/store', ['nome' => 'Novo', 'cpf' => '111.444.777-35', 'email' => 'sem-arroba'])
            ->assertSessionHasErrors(['email' => 'Informe um e-mail válido.']);
    }
}
