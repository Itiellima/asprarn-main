<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PragmaRX\Google2FA\Google2FA;
use Tests\TestCase;

/**
 * Login com autenticação em dois fatores (Fortify + pragmarx/google2fa).
 * Protege contra atualização da biblioteca que quebre os códigos de quem já ativou o 2FA.
 */
class TwoFactorLoginTest extends TestCase
{
    use RefreshDatabase;

    // Chave no formato que já está salvo no banco (base32), como a de um usuário que ativou antes
    private const CHAVE = 'JBSWY3DPEHPK3PXPJBSWY3DPEHPK3PXP';

    private function usuarioCom2fa(): User
    {
        return User::factory()->create([
            'email' => 'dois.fatores@exemplo.com',
            'password' => bcrypt('senha-forte-123'),
            'two_factor_secret' => encrypt(self::CHAVE),
            'two_factor_recovery_codes' => encrypt(json_encode(['codigo-recuperacao-1'])),
            'two_factor_confirmed_at' => now(),
        ]);
    }

    private function entrarComSenha(): void
    {
        $this->post('/login', ['email' => 'dois.fatores@exemplo.com', 'password' => 'senha-forte-123'])
            ->assertRedirect('/two-factor-challenge');

        $this->assertGuest();
    }

    public function test_login_com_codigo_do_aplicativo(): void
    {
        $usuario = $this->usuarioCom2fa();
        $this->entrarComSenha();

        $codigo = (new Google2FA())->getCurrentOtp(self::CHAVE);

        $this->post('/two-factor-challenge', ['code' => $codigo]);

        $this->assertAuthenticatedAs($usuario);
    }

    public function test_codigo_errado_nao_entra(): void
    {
        $this->usuarioCom2fa();
        $this->entrarComSenha();

        $this->post('/two-factor-challenge', ['code' => '000000']);

        $this->assertGuest();
    }

    public function test_login_com_codigo_de_recuperacao(): void
    {
        $usuario = $this->usuarioCom2fa();
        $this->entrarComSenha();

        $this->post('/two-factor-challenge', ['recovery_code' => 'codigo-recuperacao-1']);

        $this->assertAuthenticatedAs($usuario);
    }
}
