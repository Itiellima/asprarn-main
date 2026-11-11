<?php

namespace App\Rules;

use App\Helpers\CpfHelper;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/** CPF com dígitos verificadores corretos (aceita com ou sem máscara) */
class CpfValido implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!CpfHelper::validar($value)) {
            $fail('CPF inválido.');
        }
    }
}
