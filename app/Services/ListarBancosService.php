<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ListarBancosService
{
    public function listarPrincipais(): Collection
    {
        $response = Http::get('https://brasilapi.com.br/api/banks/v1');

        $codigos = [
            1,
            33,
            77,
            104,
            237,
            260,
            290,
            323,
            336,
            341,
            380,
            748,
            756,
        ];

        return collect($response->json())
            ->whereIn('code', $codigos)
            ->sortBy('code')
            ->values();
    }
}