<?php

namespace Tests\Feature;

use App\Models\Associado;
use App\Models\File;
use App\Models\PastaDocumento;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DocumentosAssociadoTest extends TestCase
{
    use RefreshDatabase;

    private Associado $associado;
    private PastaDocumento $pasta;
    private User $moderador;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('documentos');
        Storage::fake('public');

        $this->seed(RoleSeeder::class);

        $this->associado = Associado::forceCreate(['nome' => 'Fulano', 'cpf' => '11111111111']);
        $this->pasta = $this->associado->pastaDocumentos()->create(['nome' => 'Documentos pessoais']);

        $this->moderador = User::factory()->create();
        $this->moderador->assignRole('moderador');
    }

    private function enviarDocumento(): File
    {
        $this->actingAs($this->moderador)
            ->post("/associado/pasta/documentos/store/{$this->pasta->id}", [
                'tipo_documento' => 'RG',
                'arquivo' => UploadedFile::fake()->create('rg-fulano.pdf', 300, 'application/pdf'),
            ])
            ->assertSessionHas('success');

        return $this->pasta->files()->firstOrFail();
    }

    public function test_documento_e_salvo_no_bucket_privado_e_nao_no_disco_publico(): void
    {
        $file = $this->enviarDocumento();

        Storage::disk('documentos')->assertExists($file->path);
        Storage::disk('public')->assertMissing($file->path);
        $this->assertStringStartsWith("documentos/{$this->associado->id}/{$this->pasta->id}/", $file->path);
        $this->assertSame('rg-fulano.pdf', $file->tipo_documento);
    }

    public function test_moderador_abre_o_documento_pelo_laravel(): void
    {
        $file = $this->enviarDocumento();

        $resposta = $this->actingAs($this->moderador)
            ->get("/associado/pasta/documentos/show/{$this->pasta->id}/{$file->id}");

        $resposta->assertOk();
        $this->assertStringContainsString('inline', $resposta->headers->get('Content-Disposition'));
        $this->assertStringContainsString('rg-fulano.pdf', $resposta->headers->get('Content-Disposition'));
        $this->assertStringContainsString('no-store', $resposta->headers->get('Cache-Control'));
    }

    public function test_associado_e_visitante_nao_abrem_documentos(): void
    {
        $file = $this->enviarDocumento();
        $url = "/associado/pasta/documentos/show/{$this->pasta->id}/{$file->id}";

        $associadoUser = User::factory()->create(['associado_id' => $this->associado->id]);
        $associadoUser->assignRole('associado');

        $this->actingAs($associadoUser)->get($url)->assertRedirect();
        auth()->logout();
        $this->get($url)->assertRedirect();
    }

    public function test_documento_de_outra_pasta_retorna_404(): void
    {
        $file = $this->enviarDocumento();
        $outraPasta = $this->associado->pastaDocumentos()->create(['nome' => 'Outra']);

        $this->actingAs($this->moderador)
            ->get("/associado/pasta/documentos/show/{$outraPasta->id}/{$file->id}")
            ->assertNotFound();
    }

    public function test_excluir_documento_remove_do_bucket(): void
    {
        $file = $this->enviarDocumento();

        $this->actingAs($this->moderador)
            ->delete("/associado/pasta/documentos/destroy/{$this->pasta->id}/{$file->id}")
            ->assertSessionHas('success');

        Storage::disk('documentos')->assertMissing($file->path);
        $this->assertModelMissing($file);
    }

    public function test_excluir_pasta_remove_os_documentos_do_bucket(): void
    {
        $file = $this->enviarDocumento();

        $this->actingAs($this->moderador)
            ->delete("/associado/pasta/destroy/{$this->associado->id}/{$this->pasta->id}")
            ->assertSessionHas('success');

        Storage::disk('documentos')->assertMissing($file->path);
    }

    public function test_excluir_associado_remove_os_documentos_do_bucket(): void
    {
        $file = $this->enviarDocumento();

        $this->associado->delete();

        Storage::disk('documentos')->assertMissing($file->path);
        $this->assertModelMissing($file);
    }

    public function test_atualizar_status_do_documento(): void
    {
        $file = $this->enviarDocumento();

        $this->actingAs($this->moderador)
            ->patch("/associado/pasta/documentos/update/{$this->pasta->id}/{$file->id}", [
                'status' => 'recebido',
                'observacao' => 'Conferido',
            ])
            ->assertSessionHas('success');

        $this->assertSame('recebido', $file->fresh()->status);
        $this->assertSame('Conferido', $file->fresh()->observacao);
    }

    public function test_falha_no_bucket_nao_cria_registro(): void
    {
        Storage::shouldReceive('disk')->with('documentos')->andThrow(new \RuntimeException('SeaweedFS fora do ar'));

        $this->actingAs($this->moderador)
            ->post("/associado/pasta/documentos/store/{$this->pasta->id}", [
                'tipo_documento' => 'RG',
                'arquivo' => UploadedFile::fake()->create('rg.pdf', 100, 'application/pdf'),
            ])
            ->assertSessionHas('error');

        $this->assertSame(0, $this->pasta->files()->count());
    }

    public function test_arquivos_de_posts_continuam_no_disco_publico(): void
    {
        $this->assertSame('public', File::discoPara(Post::class));
        $this->assertSame('documentos', File::discoPara(PastaDocumento::class));
    }
}
