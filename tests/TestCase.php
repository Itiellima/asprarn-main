<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Storage;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Os buckets do SeaweedFS viram discos locais temporários: nenhum teste fala com S3 de verdade
        Storage::fake('documentos');
        Storage::fake('midia');
    }
}
