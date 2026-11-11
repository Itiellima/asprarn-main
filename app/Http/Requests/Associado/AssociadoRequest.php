<?php

namespace App\Http\Requests\Associado;

use App\Http\Requests\RequestComMascara;
use App\Rules\CpfValido;

/**
 * Base do cadastro e da edição do associado: limpa as máscaras e
 * concentra as regras e mensagens que valem para os dois.
 */
abstract class AssociadoRequest extends RequestComMascara
{
    protected array $camposComMascara = ['cpf', 'tel_celular', 'tel_residencial', 'tel_trabalho'];

    /** Colunas da tabela associados preenchidas pelo formulário */
    public const DADOS_PESSOAIS = [
        'nome', 'cpf', 'rg', 'org_expedidor', 'nome_pai', 'nome_mae', 'dt_nasc',
        'estado_civil', 'grau_instrucao', 'graduacao', 'nome_guerra', 'nmr_praca',
        'matricula', 'opm', 'dependentes', 'obs', 'dt_inclusao',
    ];

    public const ENDERECO = ['cep', 'logradouro', 'nmr', 'bairro', 'cidade', 'uf', 'complemento'];

    public const CONTATO = ['tel_celular', 'tel_residencial', 'tel_trabalho', 'email'];

    public const DADOS_BANCARIOS = ['codigo', 'agencia', 'banco', 'conta', 'operacao', 'tipo'];

    /** Regras comuns; o CPF único fica em cada classe (no update ignora o próprio associado) */
    protected function regrasComuns(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'cpf' => ['bail', 'required', 'digits:11', new CpfValido()],
            'dt_inclusao' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'Informe o nome do associado.',
            'cpf.required' => 'Informe o CPF.',
            'cpf.unique' => 'Já existe um associado cadastrado com esse CPF.',
            'cpf.digits' => 'O CPF deve conter exatamente 11 dígitos numéricos.',
            'email.required' => 'Informe o e-mail.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Já existe um associado com esse e-mail.',
            'picture_profile.image' => 'O arquivo deve ser uma imagem.',
            'picture_profile.mimes' => 'A foto deve ser JPG, PNG ou WEBP.',
            'picture_profile.max' => 'A foto não pode passar de 10MB.',
            'dt_inclusao.date' => 'A data de inclusão deve ser uma data válida.',
        ];
    }
}
