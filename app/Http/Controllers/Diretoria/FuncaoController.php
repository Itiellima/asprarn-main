<?php

namespace App\Http\Controllers\Diretoria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiretoriaFuncao;
use Illuminate\Validation\Rule;



class FuncaoController extends Controller
{
    public function index()
    {

        $funcoes = DiretoriaFuncao::all();

        return view('diretoria.funcoes.index', compact('funcoes'));
    }

    public function create()
    {
        $funcao = new DiretoriaFuncao();

        return view('diretoria.funcoes.create', compact('funcao'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:ativo,inativo']
        ]);

        DiretoriaFuncao::create($validated);

        return redirect()->route('diretoria.funcoes.index')->with('success', 'Nova diretoria cadastrada com sucesso.');
    }

    public function destroy($id)
    {
        $funcao = DiretoriaFuncao::findOrFail($id);


        $funcao->delete();


        return redirect()->route('diretoria.funcoes.index')->with('success', 'Função excluida com sucesso');
    }

    public function edit($id)
    {
        $funcao = DiretoriaFuncao::findOrFail($id);

        return view('diretoria.funcoes.create', compact('funcao'));
    }

    public function update(Request $request, $id)
    {
        $funcao = DiretoriaFuncao::findOrFail($id);

        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string', 'max:20', Rule::unique('diretorias', 'sigla')->ignore($funcao->id)],
            'status' => ['required', 'in:ativo,inativo'],
        ]);

        $funcao->update($validated);

        return redirect()->route('diretoria.funcoes.index')->with('success', 'Nova função cadastrada com sucesso.');
    }
}
