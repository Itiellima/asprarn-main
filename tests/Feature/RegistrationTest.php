<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Features;
use Tests\TestCase;

// O cadastro do Fortify está desligado (config/fortify.php): o /register do projeto
// é o formulário de associado, que cria o associado e o login juntos.
class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_cadastro_do_fortify_esta_desligado(): void
    {
        $this->assertFalse(Features::enabled(Features::registration()));
    }

    public function test_register_abre_o_formulario_de_associado(): void
    {
        $this->get('/register')
            ->assertOk()
            ->assertSee('Formulário de cadastro');
    }

    public function test_post_no_register_nao_cria_usuario_solto(): void
    {
        $this->post('/register', [
            'name' => 'Usuário Solto',
            'email' => 'solto@exemplo.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertMethodNotAllowed();

        $this->assertGuest();
        $this->assertNull(User::where('email', 'solto@exemplo.com')->first());
    }
}
