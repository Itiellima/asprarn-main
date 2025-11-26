<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class InstagramPost extends Component
{
    // Propriedade pública para armazenar os posts do Instagram.
    // Inicializada como array vazio.
    public array $instagram = [];

    // Método que faz a requisição à API do Instagram
    public function loadMedia()
    {
        $token = env('INSTAGRAM_ACCESS_TOKEN');
        $userId = env('INSTAGRAM_USER_ID');

        // Proteção básica para garantir que as credenciais existem
        if (!$token || !$userId) {
            // Retorna um array vazio se as credenciais estiverem faltando
            return [];
        }

        $url = "https://graph.instagram.com/{$userId}/media";

        try {
            $response = Http::get($url, [
                'fields' => 'id,caption,media_type,media_url,thumbnail_url,permalink',
                'access_token' => $token,
            ]);

            // Verifica se a requisição foi bem-sucedida
            if ($response->successful()) {
                $instagramData = $response->json();

                // Retorna apenas o array de posts da chave 'data'
                return $instagramData['data'] ?? [];
            } else {
                // Loga o erro da API se a requisição falhar
                logger()->error('Instagram API Request Failed', ['status' => $response->status(), 'body' => $response->body()]);
                return [];
            }
        } catch (\Exception $e) {
            // Loga exceções de conexão ou outras falhas
            logger()->error('Error fetching Instagram media: ' . $e->getMessage());
            return [];
        }
    }

    // O método render é chamado sempre que o componente é atualizado.
    public function render()
    {
        // Chama o método loadMedia para buscar os posts.
        $this->instagram = $this->loadMedia();

        // O método render não precisa de compact se a variável for uma propriedade pública ($this->posts)
        // Mas se você quiser passar uma variável local, o correto é:
        // return view('livewire.instagram-post', ['posts' => $this->posts]);

        // Como $posts é uma propriedade pública, ela já está disponível no Blade.
        return view('livewire.instagram-post');
    }
}
