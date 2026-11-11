<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

/**
 * Cadastro e edição de empresa conveniada (na edição, o CNPJ único ignora a própria empresa).
 * Sem authorize(): quem barra é o grupo de rotas role:admin|moderador (routes/web/admin.php).
 */
class EmpresaRequest extends RequestComMascara
{
    protected array $camposComMascara = ['cnpj', 'telefone', 'telefone_2'];

    public const CAMPOS = [
        'nome', 'cnpj', 'endereco', 'telefone', 'telefone_2', 'email', 'email_2', 'tipo_convenio',
        'horario_trabalho', 'data_inicio_contrato', 'data_fim_contrato', 'funcionarios', 'observacoes',
    ];

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'cnpj' => ['required', 'digits:14', Rule::unique('empresas', 'cnpj')->ignore($this->route('id'))],
        ];
    }

    public function messages(): array
    {
        return [
            'cnpj.required' => 'Informe o CNPJ.',
            'cnpj.digits' => 'O CNPJ deve conter exatamente 14 dígitos numéricos.',
            'cnpj.unique' => 'Já existe uma empresa com esse CNPJ cadastrado.',
        ];
    }
}
