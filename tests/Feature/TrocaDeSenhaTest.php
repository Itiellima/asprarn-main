<?php

namespace Tests\Feature;

use App\Actions\Fortify\ResetUserPassword;
use App\Models\Associado;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TrocaDeSenhaTest extends TestCase
{
    use RefreshDatabase;

    private const CPF = '12345678900';

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        $associado = Associado::forceCreate(['nome' => 'Fulano', 'cpf' => self::CPF]);

        // Mesmo estado de um associado recém-cadastrado ou com senha resetada
        $this->user = User::factory()->create([
            'email' => 'fulano@exemplo.com',
            'password' => Hash::make(self::CPF),
            'associado_id' => $associado->id,
        ]);
        $this->user->assignRole('associado');
    }

    public function test_login_com_cpf_marca_troca_obrigatoria(): void
    {
        $this->post('/login', ['email' => 'fulano@exemplo.com', 'password' => self::CPF]);

        $this->assertAuthenticatedAs($this->user);
        $this->assertTrue($this->user->fresh()->trocar_senha);

        $this->get('/dashboard')->assertRedirect(route('senha.trocar'));
    }

    public function test_login_com_cpf_formatado_tambem_marca(): void
    {
        $this->user->forceFill(['password' => Hash::make('123.456.789-00')])->save();

        $this->post('/login', ['email' => 'fulano@exemplo.com', 'password' => '123.456.789-00']);

        $this->assertTrue($this->user->fresh()->trocar_senha);
    }

    public function test_login_com_outra_senha_nao_marca(): void
    {
        $this->user->forceFill(['password' => Hash::make('outra-senha-forte')])->save();

        $this->post('/login', ['email' => 'fulano@exemplo.com', 'password' => 'outra-senha-forte']);

        $this->assertAuthenticatedAs($this->user);
        $this->assertFalse($this->user->fresh()->trocar_senha);
        $this->get('/trocar-senha')->assertRedirect(route('dashboard'));
    }

    public function test_senha_errada_continua_recusada(): void
    {
        $this->post('/login', ['email' => 'fulano@exemplo.com', 'password' => 'errada']);

        $this->assertGuest();
    }

    public function test_usuario_marcado_so_acessa_a_troca_de_senha(): void
    {
        $this->user->forceFill(['trocar_senha' => true])->save();
        $this->actingAs($this->user);

        $this->get('/trocar-senha')->assertOk()->assertSee('troque sua senha');
        $this->get("/carteira-associados/{$this->user->associado_id}")->assertRedirect(route('senha.trocar'));
        $this->getJson('/dashboard')->assertForbidden();
        $this->post('/logout')->assertRedirect();
        $this->assertGuest();
    }

    public function test_nova_senha_nao_pode_ser_o_cpf(): void
    {
        $this->user->forceFill(['trocar_senha' => true])->save();

        $this->actingAs($this->user)
            ->post('/trocar-senha', ['password' => self::CPF, 'password_confirmation' => self::CPF])
            ->assertSessionHasErrors(['password' => 'A nova senha não pode ser o seu CPF.']);

        $this->assertTrue($this->user->fresh()->trocar_senha);
    }

    public function test_confirmacao_diferente_e_recusada(): void
    {
        $this->user->forceFill(['trocar_senha' => true])->save();

        $this->actingAs($this->user)
            ->post('/trocar-senha', ['password' => 'nova-senha-forte', 'password_confirmation' => 'outra-coisa'])
            ->assertSessionHasErrors('password');

        $this->assertTrue($this->user->fresh()->trocar_senha);
    }

    public function test_troca_de_senha_libera_o_sistema(): void
    {
        $this->user->forceFill(['trocar_senha' => true])->save();

        $this->actingAs($this->user)
            ->post('/trocar-senha', ['password' => 'nova-senha-forte', 'password_confirmation' => 'nova-senha-forte'])
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('msg');

        $user = $this->user->fresh();
        $this->assertFalse($user->trocar_senha);
        $this->assertTrue(Hash::check('nova-senha-forte', $user->password));

        $this->get('/trocar-senha')->assertRedirect(route('dashboard'));
    }

    public function test_redefinir_senha_pelo_link_tambem_libera(): void
    {
        $this->user->forceFill(['trocar_senha' => true])->save();

        (new ResetUserPassword)->reset($this->user, [
            'password' => 'nova-senha-forte',
            'password_confirmation' => 'nova-senha-forte',
        ]);

        $this->assertFalse($this->user->fresh()->trocar_senha);
    }
}
