<?php

namespace Tests\Feature;

use App\Livewire\InstagramPost;
use App\Models\Banner;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PaginaInicialTest extends TestCase
{
    use RefreshDatabase;

    public function test_pagina_inicial_abre_sem_conteudo_cadastrado(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_pagina_inicial_mostra_posts_e_banners(): void
    {
        $autor = User::factory()->create();
        Post::forceCreate(['user_id' => $autor->id, 'titulo' => 'Assembleia geral de novembro', 'data' => '2026-11-09']);
        Banner::create(['titulo' => 'Banner da campanha']);

        $this->get('/')
            ->assertOk()
            ->assertSee('Assembleia geral de novembro');
    }

    public function test_falha_no_instagram_nao_derruba_a_pagina(): void
    {
        config(['services.instagram.token' => 'token', 'services.instagram.user_id' => '123']);
        Http::fake(['graph.instagram.com/*' => Http::response(['error' => 'token expirado'], 400)]);

        $this->get('/')->assertOk();
    }

    public function test_instagram_e_consultado_uma_vez_e_fica_em_cache(): void
    {
        config(['services.instagram.token' => 'token', 'services.instagram.user_id' => '123']);
        Http::fake(['graph.instagram.com/*' => Http::response(['data' => [[
            'id' => '1', 'caption' => 'Post do Instagram', 'media_type' => 'IMAGE',
            'media_url' => 'https://cdn.exemplo.com/1.jpg', 'permalink' => 'https://instagram.com/p/1',
        ]]])]);

        $this->get('/')->assertOk();
        $this->get('/')->assertOk();
        $this->get('/')->assertOk();

        // Antes era uma chamada à API por visita
        Http::assertSentCount(1);
        $this->assertCount(1, Cache::get(InstagramPost::CHAVE_CACHE));
    }

    public function test_sem_banners_mostra_o_texto_de_apresentacao(): void
    {
        // Antes, @if ($banners) era sempre verdadeiro e mostrava um carrossel vazio
        $this->get('/')
            ->assertOk()
            ->assertSee('Associação de Praças da Policia Militar do RN.')
            ->assertDontSee('carousel-inner', false);
    }

    public function test_lateral_nao_repete_os_posts_do_feed(): void
    {
        $autor = User::factory()->create();
        foreach (range(1, 9) as $n) {
            $post = Post::forceCreate(['user_id' => $autor->id, 'titulo' => "Notícia número {$n}", 'data' => '2026-11-01']);
            $post->forceFill(['created_at' => now()->subDays(10 - $n)])->save();
        }

        $html = $this->get('/')->assertOk()->assertSee('Mais notícias')->getContent();

        // Feed com os 6 mais recentes (9 a 4); lateral com os 3 seguintes (3 a 1), sem repetir
        [$feed, $lateral] = explode('Mais notícias', $html, 2);

        foreach (range(4, 9) as $n) {
            $this->assertStringContainsString("Notícia número {$n}", $feed);
            $this->assertStringNotContainsString("Notícia número {$n}", $lateral);
        }
        foreach (range(1, 3) as $n) {
            $this->assertStringNotContainsString("Notícia número {$n}", $feed);
            $this->assertStringContainsString("Notícia número {$n}", $lateral);
        }
    }

    public function test_post_sem_imagem_mostra_o_logo_e_nao_duplica_o_ponto(): void
    {
        $autor = User::factory()->create();
        Post::forceCreate([
            'user_id' => $autor->id,
            'titulo' => 'Sem imagem',
            'assunto' => 'Assunto que já tem ponto.',
            'data' => '2026-11-09',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee(asset('img/Aspra.png'), false)
            ->assertSee('Assunto que já tem ponto.')
            ->assertDontSee('Assunto que já tem ponto..')
            ->assertSee('Ver todas as notícias');
    }

    public function test_meta_tags_padrao_e_do_post(): void
    {
        $this->get('/')
            ->assertSee('<meta property="og:image" content="' . asset('img/Aspra.png') . '">', false)
            ->assertSee('ASPRA PM/RN): notícias, convênios', false);

        $autor = User::factory()->create();
        $post = Post::forceCreate([
            'user_id' => $autor->id,
            'titulo' => 'Assembleia geral',
            'texto' => '<p>Convocamos <strong>todos</strong> os associados&nbsp;para a assembleia.</p>',
            'data' => '2026-11-09',
        ]);

        $this->get(route('posts.show', $post->id))
            ->assertOk()
            ->assertSee('<meta property="og:type" content="article">', false)
            ->assertSee('<meta name="description" content="Convocamos todos os associados para a assembleia.">', false);
    }

    public function test_rota_antiga_do_instagram_foi_removida(): void
    {
        $this->get('/api/instagram/media')->assertNotFound();
    }
}
