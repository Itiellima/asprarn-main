<?php

namespace App\Http\Requests;

use App\Rules\CpfValido;
use Illuminate\Validation\Rule;

/**
 * Cadastro e edição de prestador de serviços autônomo (na edição, o CPF único ignora o próprio prestador).
 * Sem authorize(): quem barra é o grupo de rotas role:admin|moderador (routes/web/admin.php).
 */
class PrestadorDeServicosRequest extends RequestComMascara
{
    protected array $camposComMascara = ['cpf', 'telefone_1', 'telefone_2'];

    public const CAMPOS = [
        'nome', 'cpf', 'rg', 'empresa', 'funcao', 'departamento', 'atividade', 'email_pessoal',
        'email_profissional', 'telefone_1', 'telefone_2', 'endereco', 'data_admissao',
        'data_demissao', 'observacoes',
    ];

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'cpf' => ['bail', 'required', 'digits:11', new CpfValido(), Rule::unique('prestador_de_servicos_autonomos', 'cpf')->ignore($this->route('id'))],
        ];
    }

    public function messages(): array
    {
        return [
            'cpf.required' => 'Informe o CPF.',
            'cpf.digits' => 'O CPF deve conter exatamente 11 dígitos numéricos.',
            'cpf.unique' => 'Já existe um prestador de serviços com esse CPF cadastrado.',
        ];
    }
}
