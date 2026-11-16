<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Arquivos do PWA e do app Android (TWA gerado no PWABuilder, pacote br.com.asprarn.twa).
 * São estáticos (servidos pelo nginx), então o teste lê direto da pasta public/.
 */
class PwaTest extends TestCase
{
    private function publico(string $arquivo): string
    {
        return dirname(__DIR__, 2) . '/public/' . $arquivo;
    }

    private function manifesto(): array
    {
        $manifesto = json_decode(file_get_contents($this->publico('manifest.json')), true);
        $this->assertIsArray($manifesto, 'manifest.json precisa ser um JSON válido');

        return $manifesto;
    }

    public function test_id_do_app_nao_muda(): void
    {
        // Trocar o id faz o navegador tratar como outro app para quem já instalou
        $this->assertSame('/', $this->manifesto()['id']);
    }

    public function test_icones_e_capturas_do_manifesto_existem(): void
    {
        $manifesto = $this->manifesto();

        foreach (array_merge($manifesto['icons'], $manifesto['screenshots']) as $imagem) {
            $this->assertFileExists($this->publico(ltrim($imagem['src'], '/')), $imagem['src']);
        }

        $propositos = array_column($manifesto['icons'], 'purpose');
        $this->assertContains('maskable', $propositos);
        $this->assertContains('any', $propositos);
    }

    public function test_assetlinks_liga_o_site_ao_app_android(): void
    {
        // Sem isso, o app Android abre o site com a barra do navegador aparecendo
        $links = json_decode(file_get_contents($this->publico('.well-known/assetlinks.json')), true);

        $this->assertSame('br.com.asprarn.twa', $links[0]['target']['package_name']);
        $this->assertNotEmpty($links[0]['target']['sha256_cert_fingerprints']);
    }

    public function test_service_worker_guarda_a_pagina_offline_e_nao_guarda_paginas_logadas(): void
    {
        $sw = file_get_contents($this->publico('service-worker.js'));

        $this->assertFileExists($this->publico('offline.html'));
        $this->assertStringContainsString("'/offline.html'", $sw);
        // Só navegação passa pelo service worker, e nada é gravado com cache.put
        $this->assertStringContainsString("mode !== 'navigate'", $sw);
        $this->assertStringNotContainsString('cache.put', $sw);
    }
}
