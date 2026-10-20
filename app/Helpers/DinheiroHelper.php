<?php

namespace App\Helpers;

class DinheiroHelper
{
    /**
     * Converte um valor digitado (formato brasileiro ou não) para decimal com ponto.
     *
     * "1.234,56" → "1234.56" | "120,00" → "120.00" | "R$ 1.234" → "1234.00"
     * "1234.56"  → "1234.56" | 150      → "150.00"
     *
     * Retorna null se o valor não for um número válido.
     */
    public static function paraDecimal($valor): ?string
    {
        if ($valor === null || $valor === '') {
            return null;
        }

        if (is_int($valor) || is_float($valor)) {
            return number_format((float) $valor, 2, '.', '');
        }

        // Remove "R$", espaços (inclusive o não separável) e sinal de positivo
        $valor = preg_replace('/[R$\s\x{00A0}+]/u', '', (string) $valor);

        if (str_contains($valor, ',')) {
            // Formato brasileiro: ponto é milhar, vírgula é decimal
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '.', $valor);
        } elseif (preg_match('/^-?\d{1,3}(\.\d{3})+$/', $valor)) {
            // Só pontos agrupando milhares, sem decimais: "1.234" ou "1.234.567"
            $valor = str_replace('.', '', $valor);
        }

        if (!preg_match('/^-?\d+(\.\d+)?$/', $valor)) {
            return null;
        }

        return number_format((float) $valor, 2, '.', '');
    }
}
