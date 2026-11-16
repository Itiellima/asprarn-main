<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

/**
 * Últimos posts do Instagram na página inicial.
 * A resposta da API fica em cache: a página não chama o Instagram a cada visita
 * e continua de pé se a API estiver lenta, fora do ar ou com o token vencido.
 */
class InstagramPost extends Component
{
    public const CHAVE_CACHE = 'instagram.midias';

    /** Busca na API; null quando falha (para não guardar a falha por 1 hora) */
    private function buscarNaApi(): ?array
    {
        $token = config('services.instagram.token');
        $userId = config('services.instagram.user_id');

        if (!$token || !$userId) {
            return [];
        }

        try {
            $response = Http::timeout(5)->get("https://graph.instagram.com/{$userId}/media", [
                'fields' => 'id,caption,media_type,media_url,thumbnail_url,permalink',
                'access_token' => $token,
            ]);

            if ($response->successful()) {
                return $response->json('data') ?? [];
            }

            logger()->error('Instagram API Request Failed', ['status' => $response->status(), 'body' => $response->body()]);
        } catch (\Exception $e) {
            logger()->error('Error fetching Instagram media: ' . $e->getMessage());
        }

        return null;
    }

    private function midias(): array
    {
        $emCache = Cache::get(self::CHAVE_CACHE);

        if ($emCache !== null) {
            return $emCache;
        }

        $midias = $this->buscarNaApi();

        // Sucesso fica 1 hora; falha fica só 5 minutos (tenta de novo logo, sem martelar a API)
        Cache::put(self::CHAVE_CACHE, $midias ?? [], $midias === null ? now()->addMinutes(5) : now()->addHour());

        return $midias ?? [];
    }

    public function render()
    {
        // Passado direto para a view (e não como propriedade pública), para a lista
        // não ir embutida no HTML como estado do Livewire
        return view('livewire.instagram-post', ['instagram' => $this->midias()]);
    }
}
