<?php

namespace Tests\Unit;

use App\Helpers\DinheiroHelper;
use App\Helpers\MesReferenciaHelper;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class FinanceiroHelpersTest extends TestCase
{
    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public static function valores(): array
    {
        return [
            'milhar brasileiro' => ['1.234,56', '1234.56'],
            'milhão brasileiro' => ['1.234.567,89', '1234567.89'],
            'sem milhar' => ['120,00', '120.00'],
            'vírgula com uma casa' => ['120,5', '120.50'],
            'inteiro' => ['120', '120.00'],
            'com R$ e espaço' => ['R$ 1.234,56', '1234.56'],
            'ponto decimal (input number)' => ['1234.56', '1234.56'],
            'milhar só com ponto' => ['1.234', '1234.00'],
            'número inteiro do PHP' => [150, '150.00'],
            'float do PHP' => [99.9, '99.90'],
            'espaços nas pontas' => ['  45,00 ', '45.00'],
        ];
    }

    #[DataProvider('valores')]
    public function test_converte_valores_em_reais($entrada, string $esperado): void
    {
        $this->assertSame($esperado, DinheiroHelper::paraDecimal($entrada));
    }

    public function test_valor_invalido_retorna_null(): void
    {
        $this->assertNull(DinheiroHelper::paraDecimal(''));
        $this->assertNull(DinheiroHelper::paraDecimal(null));
        $this->assertNull(DinheiroHelper::paraDecimal('abc'));
        $this->assertNull(DinheiroHelper::paraDecimal('12,34,56'));
    }

    public static function meses(): array
    {
        return [
            'mm/aaaa' => ['02/2026', '2026-02-01'],
            'm/aaaa' => ['2/2026', '2026-02-01'],
            'mm-aaaa' => ['12-2025', '2025-12-01'],
            'input month' => ['2026-02', '2026-02-01'],
        ];
    }

    #[DataProvider('meses')]
    public function test_converte_mes_de_referencia(string $entrada, string $esperado): void
    {
        $this->assertSame($esperado, MesReferenciaHelper::paraData($entrada)->toDateString());
    }

    public function test_mes_nao_depende_do_dia_atual(): void
    {
        // Nos dias 29, 30 e 31 o createFromFormat('m/Y') pulava para o mês seguinte
        Carbon::setTestNow('2026-01-31 10:00:00');

        $this->assertSame('2026-02-01', MesReferenciaHelper::paraData('02/2026')->toDateString());
        $this->assertSame('2026-04-01', MesReferenciaHelper::paraData('2026-04')->toDateString());
    }

    public function test_mes_invalido_retorna_null(): void
    {
        $this->assertNull(MesReferenciaHelper::paraData('13/2026'));
        $this->assertNull(MesReferenciaHelper::paraData('00/2026'));
        $this->assertNull(MesReferenciaHelper::paraData('fevereiro'));
        $this->assertNull(MesReferenciaHelper::paraData(''));
    }
}
