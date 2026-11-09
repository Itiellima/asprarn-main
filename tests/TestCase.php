<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Os buckets do SeaweedFS viram discos locais temporários: nenhum teste fala com S3 de verdade
        Storage::fake('documentos');
        Storage::fake('midia');

        // Nenhum teste chama serviços reais (n8n de produção, Instagram, IBGE): pedido HTTP
        // sem Http::fake() correspondente vira erro em vez de sair para a internet
        Http::preventStrayRequests();
    }
}
