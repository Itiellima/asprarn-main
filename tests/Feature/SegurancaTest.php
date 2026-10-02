<?php

namespace Tests\Feature;

use App\Helpers\CpfHelper;
use App\Models\Associado;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SegurancaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
    }

    private function usuarioComRole(string $role, array $atributos = []): User
    {
        $user = User::factory()->create($atributos);
        $user->assignRole($role);

        return $user;
    }

    private function adminAssociado(): Associado
    {
        $associado = Associado::forceCreate(['nome' => 'Admin Associado', 'cpf' => '98765432100']);
        $this->usuarioComRole('admin', ['associado_id' => $associado->id, 'password' => Hash::make('senha-forte')]);

        return $associado;
    }

    // Item 1: CPF mascarado na verificação pública da carteirinha

    public function test_cpf_e_mascarado(): void
    {
        $this->assertSame('***.456.789-**', CpfHelper::mascarar('12345678900'));
        $this->assertSame('***.456.789-**', CpfHelper::mascarar('123.456.789-00'));
        $this->assertSame('***.345.678-**', CpfHelper::mascarar('1234567890')); // zero à esquerda perdido
    }

    public function test_verificacao_publica_nao_mostra_cpf_completo(): void
    {
        $associado = Associado::forceCreate(['nome' => 'Fulano de Tal', 'cpf' => '12345678900']);

        $this->get("/carteira-associado-verificacao/{$associado->id}")
            ->assertOk()
            ->assertSee('Fulano de Tal')
            ->assertSee('***.456.789-**')
            ->assertDontSee('12345678900');
    }

    // Item 3: moderador não reseta senha de admin

    public function test_moderador_nao_reseta_senha_de_admin_pelo_associado(): void
    {
        $associado = $this->adminAssociado();

        $this->actingAs($this->usuarioComRole('moderador'))
            ->post("/associado/resetpassword/{$associado->id}")
            ->assertSessionHas('error');

        $this->assertTrue(Hash::check('senha-forte', $associado->user->fresh()->password));
    }

    public function test_moderador_nao_reseta_senha_de_admin_pelos_usuarios(): void
    {
        $associado = $this->adminAssociado();

        $this->actingAs($this->usuarioComRole('moderador'))
            ->post("/usuarios/{$associado->user->id}/reset-password")
            ->assertSessionHas('error');

        $this->assertTrue(Hash::check('senha-forte', $associado->user->fresh()->password));
    }

    public function test_admin_reseta_senha_de_admin(): void
    {
        $associado = $this->adminAssociado();

        $this->actingAs($this->usuarioComRole('admin'))
            ->post("/associado/resetpassword/{$associado->id}")
            ->assertSessionHas('success');

        $this->assertTrue(Hash::check('98765432100', $associado->user->fresh()->password));
    }

    public function test_moderador_continua_resetando_senha_de_associado(): void
    {
        $associado = Associado::forceCreate(['nome' => 'Associado Comum', 'cpf' => '11122233344']);
        $this->usuarioComRole('associado', ['associado_id' => $associado->id]);

        $this->actingAs($this->usuarioComRole('moderador'))
            ->post("/associado/resetpassword/{$associado->id}")
            ->assertSessionHas('success');

        $this->assertTrue(Hash::check('11122233344', $associado->user->fresh()->password));
    }

    public function test_reset_de_usuario_sem_associado_nao_quebra(): void
    {
        $semAssociado = $this->usuarioComRole('user');

        $this->actingAs($this->usuarioComRole('admin'))
            ->post("/usuarios/{$semAssociado->id}/reset-password")
            ->assertRedirect()
            ->assertSessionHas('error');
    }

    // Item 5: busca na pasta não mostra documentos de outros associados

    public function test_busca_na_pasta_nao_mostra_documentos_de_outro_associado(): void
    {
        $fulano = Associado::forceCreate(['nome' => 'Fulano', 'cpf' => '11111111111']);
        $ciclano = Associado::forceCreate(['nome' => 'Ciclano', 'cpf' => '22222222222']);

        $pastaFulano = $fulano->pastaDocumentos()->create(['nome' => 'Docs Fulano']);
        $pastaCiclano = $ciclano->pastaDocumentos()->create(['nome' => 'Docs Ciclano']);

        $pastaFulano->files()->create(['path' => 'documentos/a.pdf', 'tipo_documento' => 'RG-DO-FULANO', 'status' => 'pendente']);
        $pastaCiclano->files()->create(['path' => 'documentos/b.pdf', 'tipo_documento' => 'RG-DO-CICLANO', 'status' => 'pendente']);

        $this->actingAs($this->usuarioComRole('moderador'))
            ->get("/associado/pasta/show/{$fulano->id}/{$pastaFulano->id}?search=pendente")
            ->assertOk()
            ->assertViewHas('documentos', function ($documentos) {
                $tipos = $documentos->pluck('tipo_documento');

                return $tipos->contains('RG-DO-FULANO') && !$tipos->contains('RG-DO-CICLANO');
            });
    }

    // Item 4: rota de WhatsApp removida

    public function test_rota_de_envio_de_whatsapp_nao_existe_mais(): void
    {
        $this->post('/enviar-mensagens', ['numeros' => ['84999999999'], 'mensagem' => 'x', 'nome' => 'x'])
            ->assertNotFound();
    }
}
