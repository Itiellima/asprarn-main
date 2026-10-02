<?php

namespace App\Helpers;

class CpfHelper
{
    public static function validar($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) !== 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $soma = 0;
            for ($i = 0; $i < $t; $i++) {
                $soma += $cpf[$i] * (($t + 1) - $i);
            }
            $digito = (10 * $soma) % 11;
            $digito = ($digito == 10) ? 0 : $digito;

            if ($cpf[$t] != $digito) {
                return false;
            }
        }

        return true;
    }

    /**
     * Mascara o CPF para exibição pública: ***.456.789-**
     */
    public static function mascarar($cpf)
    {
        $cpf = str_pad(preg_replace('/[^0-9]/', '', (string) $cpf), 11, '0', STR_PAD_LEFT);

        return '***.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-**';
    }
}
