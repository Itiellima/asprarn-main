<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Associado;
use App\Models\Situacao;

class SituacaoController extends Controller
{
    // Criar nova situacao
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        Situacao::create([
            'nome' => $request->input('nome'),
        ]);

        return redirect()->back()->with('success', 'Situação criada com sucesso!');
    }

    public function update(Request $request, $associadoId)
    {
        // Verifica se o associado existe
        $associado = Associado::findOrFail($associadoId);

        // Id inexistente viraria erro de chave estrangeira (500); aqui vira mensagem
        $dados = $request->validate([
            'situacoes' => ['nullable', 'array'],
            'situacoes.*' => ['integer', 'exists:situacoes,id'],
        ], [
            'situacoes.*.exists' => 'Situação inválida.',
        ]);

        $associado->situacoes()->sync($dados['situacoes'] ?? []);

        return redirect()->back()->with('success', 'Situação atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $situacao = Situacao::findOrFail($id);

        $situacao->delete();

        return redirect()->back()->with('success', 'Situação excluída com sucesso!');
    }

    public function edit(Request $request, $id)
    {
        $situacao = Situacao::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $situacao->update([
            'nome' => $request->input('nome'),
        ]);


        return redirect()->back()->with('success', 'Situação atualizada com sucesso!');
    }

}
