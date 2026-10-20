<?php

namespace App\Helpers;

use Carbon\Carbon;

class MesReferenciaHelper
{
    /**
     * Converte o mês de referência para o primeiro dia do mês.
     *
     * Aceita "02/2026", "2/2026", "02-2026" e "2026-02" (campo <input type="month">).
     * Não depende do dia atual: "02/2026" num dia 30 continua sendo fevereiro.
     *
     * Retorna null se o mês não for válido.
     */
    public static function paraData($mes): ?Carbon
    {
        $mes = trim((string) $mes);

        if (preg_match('/^(\d{1,2})[\/-](\d{4})$/', $mes, $partes)) {
            [, $numeroMes, $ano] = $partes;
        } elseif (preg_match('/^(\d{4})-(\d{1,2})$/', $mes, $partes)) {
            [, $ano, $numeroMes] = $partes;
        } else {
            return null;
        }

        $numeroMes = (int) $numeroMes;

        if ($numeroMes < 1 || $numeroMes > 12) {
            return null;
        }

        return Carbon::create((int) $ano, $numeroMes, 1)->startOfDay();
    }
}
