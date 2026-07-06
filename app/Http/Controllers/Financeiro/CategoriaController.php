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

        return view('financeiro.categoria.index', compact('categorias'));
    }

    public function createCategoria()
    {
        $categoria = new FinanceiroCategoria();

        return view('financeiro.categoria.create', compact('categoria'));
    }

    public function criarCategoria(Request $request)
    {

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string',
            'descricao' => 'nullable|string',
        ]);

        FinanceiroCategoria::create($validated);

        return redirect()->route('financeiro.categoria.index')->with('success', 'Categoria criada com sucesso!');
    }

    public function editarCategoria($id)
    {
        $categoria = FinanceiroCategoria::findOrFail($id);

        return view('financeiro.categoria.create', compact('categoria'));
    }

    public function updateCategoria(Request $request, $id)
    {
        $categoria = FinanceiroCategoria::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string',
            'descricao' => 'nullable|string',
        ]);

        $categoria->update($validated);

        return redirect()->route('financeiro.categoria.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    public function excluirCategoria($id)
    {
        $categoria = FinanceiroCategoria::findOrFail($id);
        $categoria->delete();

        return redirect()->route('financeiro.categoria.index')->with('success', 'Categoria excluída com sucesso!');
    }
}
