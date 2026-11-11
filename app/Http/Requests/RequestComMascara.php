<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Formulário com campos digitados com máscara (CPF, CNPJ, telefone):
 * antes de validar, deixa só os números. Assim "529.982.247-25" e
 * "52998224725" são o mesmo valor para o digits e para o unique.
 */
abstract class RequestComMascara extends FormRequest
{
    /** @var string[] */
    protected array $camposComMascara = [];

    protected function prepareForValidation(): void
    {
        $limpos = [];

        foreach ($this->camposComMascara as $campo) {
            if ($this->has($campo)) {
                $limpos[$campo] = preg_replace('/\D/', '', (string) $this->input($campo));
            }
        }

        $this->merge($limpos);
    }
}
