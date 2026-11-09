<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// O link de recuperação não sai por e-mail do Laravel: User::sendPasswordResetNotification
// manda os dados para o n8n, que envia a mensagem. Aqui o n8n é simulado.
class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['services.n8n.token' => 'chave-n8n']);
        Http::fake(['n8n.asprarn.com.br/*' => Http::response()]);
    }

    /** Pede o link e devolve o token que foi enviado ao n8n */
    private function pedirLink(User $user): string
    {
        $this->post('/forgot-password', ['email' => $user->email])->assertSessionHasNoErrors();

        $enviado = Http::recorded(fn (Request $request) => $request['evento'] === 'reset_password')->first();
        $this->assertNotNull($enviado, 'O pedido de recuperação não foi enviado ao n8n.');

        preg_match('#/reset-password/([^?]+)#', $enviado[0]['url'], $partes);

        return $partes[1];
    }

    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $this->get('/forgot-password')->assertOk();
    }

    public function test_link_de_recuperacao_vai_para_o_n8n(): void
    {
        $user = User::factory()->create();

        $this->pedirLink($user);

        Http::assertSent(fn (Request $request) => $request->hasHeader('x-api-key', 'chave-n8n')
            && $request['evento'] === 'reset_password'
            && $request['email'] === $user->email
            && str_contains($request['url'], '/reset-password/'));
    }

    public function test_email_desconhecido_nao_chama_o_n8n(): void
    {
        $this->post('/forgot-password', ['email' => 'ninguem@exemplo.com']);

        Http::assertNothingSent();
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        $token = $this->pedirLink(User::factory()->create());

        $this->get("/reset-password/{$token}")->assertOk();
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        $user = User::factory()->create();
        $user->forceFill(['trocar_senha' => true])->save();
        $token = $this->pedirLink($user);

        $this->post('/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'NovaSenha123',
            'password_confirmation' => 'NovaSenha123',
        ])->assertSessionHasNoErrors();

        $user->refresh();
        $this->assertTrue(Hash::check('NovaSenha123', $user->password));
        // Quem definiu a própria senha não precisa mais trocá-la
        $this->assertFalse($user->trocar_senha);
    }
}
