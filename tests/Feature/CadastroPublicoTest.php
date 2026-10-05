<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CadastroPublicoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        // Webhooks do n8n (boas-vindas)
        Http::fake();
    }

    private function cadastrar()
    {
        return $this->post('/associado/store', [
            'nome' => 'Fulano de Tal',
            'cpf' => '529.982.247-25',
            'email' => 'fulano@exemplo.com',
        ]);
    }

    public function test_visitante_cadastrado_vai_ao_login_com_instrucoes_de_primeiro_acesso(): void
    {
        $this->cadastrar()
            ->assertRedirect(route('login'))
            ->assertSessionHas('primeiro_acesso', 'fulano@exemplo.com');

        $this->assertGuest();

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Cadastro realizado com sucesso!')
            ->assertSee('o seu CPF, somente números')
            ->assertSee('value="fulano@exemplo.com"', false);
    }

    public function test_instrucoes_permitem_o_primeiro_login_e_exigem_troca_de_senha(): void
    {
        $this->cadastrar();

        $this->post('/login', ['email' => 'fulano@exemplo.com', 'password' => '52998224725']);

        $this->assertAuthenticated();
        $this->assertTrue(User::where('email', 'fulano@exemplo.com')->first()->trocar_senha);
        $this->get('/dashboard')->assertRedirect(route('senha.trocar'));
    }

    public function test_login_normal_nao_mostra_o_aviso(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertDontSee('Cadastro realizado com sucesso!');
    }
}
