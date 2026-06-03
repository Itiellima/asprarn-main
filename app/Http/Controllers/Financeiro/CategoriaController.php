<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinanceiroCategoria;

class CategoriaController extends Controller
{
    public function categoria()
    {

        $categorias = FinanceiroCategoria::all();

        return view('financeiro.categoria', compact('categorias'));
    }

    public function createCategoria()
    {
        return view('financeiro.categoria.create');
    }

    public function criarCategoria(Request $request)
    {

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string',
            'descricao' => 'nullable|string',
        ]);

        FinanceiroCategoria::create($validated);

        return redirect()->route('financeiro.categoria')->with('success', 'Categoria criada com sucesso!');
    }

    public function editarCategoria(Request $request, $id)
    {
        $categoria = FinanceiroCategoria::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string',
            'descricao' => 'nullable|string',
        ]);

        $categoria->update($validated);

        return redirect()->route('financeiro.categoria')->with('success', 'Categoria atualizada com sucesso!');
    }

    public function excluirCategoria($id)
    {
        $categoria = FinanceiroCategoria::findOrFail($id);
        $categoria->delete();

        return redirect()->route('financeiro.categoria')->with('success', 'Categoria excluída com sucesso!');
    }
}
