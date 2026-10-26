<?php

namespace Tests\Feature;

use App\Models\Associado;
use App\Models\Banner;
use App\Models\PictureProfile;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportDisablingBackButtonCache\SupportDisablingBackButtonCache;
use Tests\TestCase;

class MidiaTest extends TestCase
{
    use RefreshDatabase;

    public function test_imagem_do_bucket_e_entregue_sem_login_e_com_cache(): void
    {
        // Flag estática do Livewire que fica ligada por testes anteriores no mesmo processo
        SupportDisablingBackButtonCache::$disableBackButtonCache = false;

        $path = UploadedFile::fake()->image('foto.jpg')->store('picture_profiles', 'midia');

        $resposta = $this->get("/midia/{$path}");

        $resposta->assertOk();
        $this->assertSame('image/jpeg', $resposta->headers->get('Content-Type'));
        $this->assertStringContainsString('max-age=31536000', $resposta->headers->get('Cache-Control'));
        // Não abre sessão para servir imagem
        $this->assertEmpty($resposta->headers->getCookies());
    }

    public function test_imagem_inexistente_da_404(): void
    {
        $this->get('/midia/img/nao-existe.jpg')->assertNotFound();
    }

    public function test_rota_so_aceita_as_pastas_de_midia(): void
    {
        Storage::disk('midia')->put('documentos/1/1/rg.pdf', 'conteudo');

        $this->get('/midia/documentos/1/1/rg.pdf')->assertNotFound();
        $this->get('/midia/img/../documentos/1/1/rg.pdf')->assertNotFound();
    }

    public function test_url_da_foto_e_do_arquivo_aponta_para_a_rota_de_midia(): void
    {
        $associado = Associado::forceCreate(['nome' => 'Fulano', 'cpf' => '11111111111']);
        $foto = PictureProfile::create(['associado_id' => $associado->id, 'path' => 'picture_profiles/abc.jpg']);

        $this->assertSame(url('/midia/picture_profiles/abc.jpg'), $foto->url);
    }

    public function test_limpeza_simulada_nao_apaga_nada(): void
    {
        [$comArquivo, $semArquivo] = $this->criarFotos();

        $this->artisan('arquivos:limpar-orfaos', ['--simular' => true])
            ->expectsOutputToContain('1 registro(s) seriam removidos.')
            ->assertSuccessful();

        $this->assertNotNull($comArquivo->fresh());
        $this->assertNotNull($semArquivo->fresh());
    }

    public function test_limpeza_remove_so_os_registros_sem_arquivo(): void
    {
        [$comArquivo, $semArquivo] = $this->criarFotos();

        $banner = Banner::create(['titulo' => 'Banner']);
        $imagemPerdida = $banner->files()->create(['path' => 'img/perdida.jpg']);
        $imagemSalva = $banner->files()->create([
            'path' => UploadedFile::fake()->image('capa.jpg')->store('img', 'midia'),
        ]);

        $this->artisan('arquivos:limpar-orfaos')
            ->expectsOutputToContain('2 registro(s) removidos.')
            ->assertSuccessful();

        $this->assertNotNull($comArquivo->fresh());
        $this->assertNull($semArquivo->fresh());
        $this->assertNull($imagemPerdida->fresh());
        $this->assertNotNull($imagemSalva->fresh());
    }

    public function test_upload_de_banner_vai_para_o_bucket_de_midia(): void
    {
        $this->seed(RoleSeeder::class);
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin)->post('/banner/store', [
            'titulo' => 'Banner',
            'arquivos' => UploadedFile::fake()->image('banner.jpg'),
        ]);

        $arquivos = Storage::disk('midia')->files('img');
        $this->assertCount(1, $arquivos);
    }

    private function criarFotos(): array
    {
        $a = Associado::forceCreate(['nome' => 'Com foto', 'cpf' => '11111111111']);
        $b = Associado::forceCreate(['nome' => 'Sem foto', 'cpf' => '22222222222']);

        $comArquivo = PictureProfile::create([
            'associado_id' => $a->id,
            'path' => UploadedFile::fake()->image('a.jpg')->store('picture_profiles', 'midia'),
        ]);
        $semArquivo = PictureProfile::create(['associado_id' => $b->id, 'path' => 'picture_profiles/sumiu.jpg']);

        return [$comArquivo, $semArquivo];
    }
}
