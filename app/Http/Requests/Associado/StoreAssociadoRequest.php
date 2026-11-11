<?php

namespace App\Http\Requests\Associado;

/**
 * Cadastro: público (formulário do site) ou feito por admin/moderador.
 * Sem authorize(): qualquer visitante pode se cadastrar.
 */
class StoreAssociadoRequest extends AssociadoRequest
{
    public function rules(): array
    {
        $regras = $this->regrasComuns();
        $regras['cpf'][] = 'unique:associados,cpf';

        return $regras + [
            // O e-mail vira o login do associado
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'picture_profile' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
        ];
    }
}
