<?php

namespace Tests\Feature;

use App\Models\Associado;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class DocumentosImpressaoTest extends TestCase
{
    use RefreshDatabase;

    private Associado $associado;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        // Sem endereço e sem contato: antes o requerimento dava erro 500 nesse caso
        $this->associado = Associado::forceCreate([
            'nome' => 'Fulano de Tal',
            'cpf' => '11122233344',
            'rg' => '1234567',
            'matricula' => '987654',
            'dt_nasc' => '1990-05-20',
        ]);
    }

    // Documentos que usam o layout compartilhado (associado/pdf/layout.blade.php)
    public static function documentosDoLayout(): array
    {
        return [
            'requerimento' => ['/pdf.requerimento/%d', 'REQUERIMENTO'],
            'sesc' => ['/pdf.sesc/%d', 'Credencial SESC'],
            'unp' => ['/pdf.unp/%d', 'Universidade Potiguar'],
            'declaração' => ['/pdf.declaracao/%d', 'Finalidade da declaração'],
            'desfiliação' => ['/pdf.desfiliacao/%d', 'REQUERIMENTO DE DESFILIAÇÃO'],
        ];
    }

    // Documentos mais novos, com layout próprio
    public static function documentosNovos(): array
    {
        return [
            'termo de adesão ACP' => ['/pdf.termo-de-adesao-acp/%d', 'Fulano de Tal'],
            'beneficiários / procuração' => ['/pdf.beneficiarios-procuracao/%d', 'Fulano de Tal'],
            'declaração de associado' => ['/pdf.declaracao-associado-promocao/%d', 'Fulano de Tal'],
        ];
    }

    public static function documentos(): array
    {
        return self::documentosDoLayout() + self::documentosNovos();
    }

    #[DataProvider('documentos')]
    public function test_documento_abre_mesmo_sem_endereco_e_contato(string $url, string $texto): void
    {
        $this->abrirDocumento($url, $texto);
    }

    #[DataProvider('documentosNovos')]
    public function test_documento_novo_abre_com_endereco_e_contato(string $url, string $texto): void
    {
        $this->associado->endereco()->create(['logradouro' => 'Rua A', 'nmr' => '10', 'bairro' => 'Centro', 'cidade' => 'Natal', 'uf' => 'RN']);
        $this->associado->contato()->create(['tel_celular' => '84999999999', 'email' => 'fulano@exemplo.com']);

        $this->abrirDocumento($url, $texto);
    }

    private function abrirDocumento(string $url, string $texto): void
    {
        $moderador = User::factory()->create();
        $moderador->assignRole('moderador');

        $this->actingAs($moderador)
            ->get(sprintf($url, $this->associado->id))
            ->assertOk()
            ->assertSee($texto)
            ->assertSee('Fulano de Tal')
            ->assertSee('Limpar campos')
            ->assertSee('onclick="window.print()"', false)
            // A impressão não abre mais sozinha ao carregar a página
            ->assertDontSee('window.onload', false);
    }

    public function test_requerimento_preenche_os_dados_do_associado(): void
    {
        $moderador = User::factory()->create();
        $moderador->assignRole('moderador');

        $this->actingAs($moderador)
            ->get("/pdf.requerimento/{$this->associado->id}")
            ->assertSee('11122233344')
            ->assertSee('987654')
            ->assertSee('20/05/1990')
            // Rodapé próprio do requerimento
            ->assertSee('contatoasprarn@gmail.com');
    }

    #[DataProvider('documentos')]
    public function test_associado_nao_abre_documentos(string $url): void
    {
        $user = User::factory()->create(['associado_id' => $this->associado->id]);
        $user->assignRole('associado');

        $this->actingAs($user)
            ->get(sprintf($url, $this->associado->id))
            ->assertRedirect();
    }
}
