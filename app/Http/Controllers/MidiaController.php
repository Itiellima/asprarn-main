<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToRetrieveMetadata;

class MidiaController extends Controller
{
    // Entrega fotos e imagens do bucket de mídia. O bucket não é exposto na
    // internet: o navegador pede aqui e o Laravel lê pela rede interna.
    public function show(string $path)
    {
        $disco = Storage::disk('midia');

        try {
            return $disco->response($path, null, [
                // Os nomes são gerados aleatoriamente no upload e nunca mudam de conteúdo
                'Cache-Control' => 'public, max-age=31536000, immutable',
                'X-Content-Type-Options' => 'nosniff',
            ]);
        } catch (UnableToReadFile|UnableToRetrieveMetadata) {
            abort(404);
        }
    }
}
