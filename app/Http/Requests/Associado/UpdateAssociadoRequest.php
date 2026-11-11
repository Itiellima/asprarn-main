<?php

namespace App\Http\Requests\Associado;

use Illuminate\Validation\Rule;

/**
 * Edição pelo painel.
 * Sem authorize(): quem barra é o grupo de rotas role:admin|moderador (routes/web/admin.php).
 */
class UpdateAssociadoRequest extends AssociadoRequest
{
    public function rules(): array
    {
        $regras = $this->regrasComuns();
        $regras['cpf'][] = Rule::unique('associados', 'cpf')->ignore($this->route('id'));

        return $regras;
    }
}
