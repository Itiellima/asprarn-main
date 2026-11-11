<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/** Estados e municípios da API pública do IBGE, usados nos formulários de endereço */
class IbgeService
{
    /** Estados ordenados por nome; lista vazia se o IBGE estiver fora do ar */
    public function estados(): array
    {
        try {
            $response = Http::timeout(5)->get('https://servicodados.ibge.gov.br/api/v1/localidades/estados');
        } catch (\Exception $e) {
            return [];
        }

        if (!$response->successful()) {
            return [];
        }

        return collect($response->json())->sortBy('nome')->values()->all();
    }
}
