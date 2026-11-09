<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
