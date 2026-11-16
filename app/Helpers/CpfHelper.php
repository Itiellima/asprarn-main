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
     * Formata o CPF para exibição ao próprio associado: 529.982.247-25.
     * O banco guarda só os números; se não tiver 11 dígitos, devolve como está.
     */
    public static function formatar($cpf)
    {
        $numeros = preg_replace('/[^0-9]/', '', (string) $cpf);

        if (strlen($numeros) !== 11) {
            return $cpf;
        }

        return substr($numeros, 0, 3) . '.' . substr($numeros, 3, 3) . '.' . substr($numeros, 6, 3) . '-' . substr($numeros, 9, 2);
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
