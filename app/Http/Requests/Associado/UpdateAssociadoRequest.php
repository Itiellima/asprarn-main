<?php

namespace App\Http\Requests\Associado;

use App\Models\User;
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

        // O e-mail da ficha também é o login (o controller sincroniza): não pode ser o de outro usuário.
        // Vazio é aceito e não mexe no login.
        $usuarioId = User::where('associado_id', $this->route('id'))->value('id');
        $regras['email'] = ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($usuarioId)];

        return $regras;
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Este e-mail já é o login de outro usuário.',
        ] + parent::messages();
    }
}
