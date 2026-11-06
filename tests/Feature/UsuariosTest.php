<?php

namespace Tests\Feature;

use App\Models\Associado;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UsuariosTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        $this->admin = User::factory()->create(['name' => 'Admin Principal']);
        $this->admin->assignRole('admin');
    }

    private function usuario(string ...$perfis): User
    {
        $usuario = User::factory()->create();
        $usuario->assignRole($perfis);

        return $usuario;
    }

    public function test_lista_mostra_perfis_e_vinculo_com_associado(): void
    {
        $associado = Associado::forceCreate(['nome' => 'Fulano de Tal', 'cpf' => '52998224725']);
        User::factory()->create(['name' => 'Usuário Fulano', 'associado_id' => $associado->id])->assignRole('financeiro');

        $this->actingAs($this->admin)->get('/usuarios')
            ->assertOk()
            ->assertSee('Usuário Fulano')
            ->assertSee('Fulano de Tal')
            ->assertSee('***.982.247-**')
            ->assertDontSee('52998224725');
    }

    public function test_filtra_por_perfil(): void
    {
        User::factory()->create(['name' => 'Fulana Financeira'])->assignRole('financeiro');
        User::factory()->create(['name' => 'Moderador Beltrano'])->assignRole('moderador');

        $this->actingAs($this->admin)->get('/usuarios?perfil=financeiro')
            ->assertOk()
            ->assertSee('Fulana Financeira')
            ->assertDontSee('Moderador Beltrano');
    }

    public function test_filtro_com_perfil_inexistente_mostra_todos(): void
    {
        $this->actingAs($this->admin)->get('/usuarios?perfil=nao-existe')
            ->assertOk()
            ->assertSee('Admin Principal');
    }

    public function test_atualiza_os_perfis(): void
    {
        $usuario = $this->usuario('user');

        $this->actingAs($this->admin)
            ->post("/usuarios/{$usuario->id}/role", ['roles' => ['financeiro', 'associado']])
            ->assertSessionHas('success');

        $this->assertEqualsCanonicalizing(['financeiro', 'associado'], $usuario->fresh()->getRoleNames()->all());
    }

    public function test_perfil_inexistente_e_recusado(): void
    {
        $usuario = $this->usuario('user');

        $this->actingAs($this->admin)
            ->post("/usuarios/{$usuario->id}/role", ['roles' => ['superusuario']])
            ->assertSessionHasErrors('roles.0');

        $this->assertTrue($usuario->fresh()->hasRole('user'));
    }

    public function test_admin_nao_remove_o_proprio_perfil_de_admin(): void
    {
        $this->usuario('admin'); // não é o último admin

        $this->actingAs($this->admin)
            ->post("/usuarios/{$this->admin->id}/role", ['roles' => ['associado']])
            ->assertSessionHas('error');

        $this->assertTrue($this->admin->fresh()->hasRole('admin'));
    }

    public function test_ultimo_admin_nao_perde_o_perfil(): void
    {
        // Um segundo admin tenta rebaixar o primeiro e depois é rebaixado: sobra só um
        $outro = $this->usuario('admin');

        $this->actingAs($outro)
            ->post("/usuarios/{$this->admin->id}/role", ['roles' => ['moderador']])
            ->assertSessionHas('success');

        $this->actingAs($this->admin->fresh())
            ->post("/usuarios/{$outro->id}/role", ['roles' => []]);

        $this->assertTrue($outro->fresh()->hasRole('admin'));
    }

    public function test_admin_nao_apaga_a_propria_conta(): void
    {
        $this->actingAs($this->admin)
            ->delete("/usuarios/{$this->admin->id}")
            ->assertSessionHas('error');

        $this->assertNotNull($this->admin->fresh());
    }

    public function test_apaga_outro_usuario(): void
    {
        $usuario = $this->usuario('associado');

        $this->actingAs($this->admin)
            ->delete("/usuarios/{$usuario->id}")
            ->assertSessionHas('success');

        $this->assertNull($usuario->fresh());
    }

    public function test_reset_usa_o_cpf_sem_pontuacao_e_exige_troca(): void
    {
        $associado = Associado::forceCreate(['nome' => 'Fulano', 'cpf' => '529.982.247-25']);
        $usuario = User::factory()->create(['associado_id' => $associado->id]);
        $usuario->assignRole('associado');

        $this->actingAs($this->admin)
            ->post("/usuarios/{$usuario->id}/reset-password")
            ->assertSessionHas('success');

        $usuario->refresh();
        $this->assertTrue(Hash::check('52998224725', $usuario->password));
        $this->assertTrue($usuario->trocar_senha);
    }

    public function test_tela_trava_o_admin_do_proprio_usuario(): void
    {
        $this->actingAs($this->admin)->get('/usuarios')
            ->assertOk()
            ->assertSee('Você não pode remover o seu próprio perfil de admin.');
    }
}
