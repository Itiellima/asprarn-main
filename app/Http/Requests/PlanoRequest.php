<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Cadastro e edição de plano.
 * Sem authorize(): quem barra é o grupo de rotas role:admin|financeiro (routes/web/financeiro.php).
 */
class PlanoRequest extends FormRequest
{
    public const CAMPOS = ['nome', 'beneficios', 'descricao', 'preco'];

    /** O valor chega com a máscara brasileira ("1.234,56"); o banco espera "1234.56" */
    protected function prepareForValidation(): void
    {
        $preco = (string) $this->input('preco');

        if (str_contains($preco, ',')) {
            $this->merge(['preco' => str_replace(['.', ','], ['', '.'], $preco)]);
        }
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'beneficios' => ['required', 'array', 'min:1'],
            'beneficios.*' => ['required', 'string', 'max:500'],
            'descricao' => ['required', 'string', 'max:500'],
            // decimal(10,2) no banco
            'preco' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
        ];
    }

    public function messages(): array
    {
        return [
            'beneficios.required' => 'Informe pelo menos um benefício.',
            'beneficios.*.required' => 'Preencha o benefício ou remova o campo.',
            'beneficios.*.max' => 'Cada benefício não pode exceder 500 caracteres.',
            'descricao.max' => 'Descrição não pode exceder 500 caracteres.',
            'preco.numeric' => 'Informe um valor válido.',
            'preco.min' => 'O valor não pode ser negativo.',
            'preco.max' => 'Valor muito alto.',
        ];
    }
}
