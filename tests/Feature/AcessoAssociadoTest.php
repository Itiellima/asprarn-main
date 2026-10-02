<?php

namespace Tests\Feature;

use App\Models\Associado;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AcessoAssociadoTest extends TestCase
{
    use RefreshDatabase;

    private Associado $proprio;
    private Associado $outro;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        $this->proprio = Associado::forceCreate(['nome' => 'Associado Logado', 'cpf' => '11111111111']);
        $this->outro = Associado::forceCreate(['nome' => 'Outro Associado', 'cpf' => '22222222222']);
    }

    private function usuarioAssociado(): User
    {
        $user = User::factory()->create(['associado_id' => $this->proprio->id]);
        $user->assignRole('associado');

        return $user;
    }

    /**
     * Rotas que recebem o id do associado na URL.
     */
    public static function rotasDoAssociado(): array
    {
        return [
            'informações' => ['get', '/asssociado/informacoes/%d'],
            'carteirinha' => ['get', '/carteira-associados/%d'],
            'carteirinha vertical' => ['get', '/carteira-associados1/%d'],
            'enviar foto' => ['post', '/associado/%d/picture-profile/store'],
            'remover foto' => ['delete', '/associado/%d/picture-profile/destroy'],
        ];
    }

    #[DataProvider('rotasDoAssociado')]
    public function test_associado_nao_acessa_dados_de_outro_associado(string $metodo, string $url): void
    {
        $this->actingAs($this->usuarioAssociado())
            ->{$metodo}(sprintf($url, $this->outro->id))
            ->assertForbidden();
    }

    #[DataProvider('rotasDoAssociado')]
    public function test_visitante_nao_acessa_dados_de_associado(string $metodo, string $url): void
    {
        $this->{$metodo}(sprintf($url, $this->outro->id))
            ->assertForbidden();
    }

    public function test_associado_pode_remover_a_propria_foto(): void
    {
        $this->actingAs($this->usuarioAssociado())
            ->delete("/associado/{$this->proprio->id}/picture-profile/destroy")
            ->assertRedirect()
            ->assertSessionHas('msg');
    }

    public function test_moderador_pode_remover_foto_de_qualquer_associado(): void
    {
        $moderador = User::factory()->create();
        $moderador->assignRole('moderador');

        $this->actingAs($moderador)
            ->delete("/associado/{$this->outro->id}/picture-profile/destroy")
            ->assertRedirect()
            ->assertSessionHas('msg');
    }
}
