<?php

namespace App\Http\Controllers\Diretoria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diretoria;
use Illuminate\Validation\Rule;

class DiretoriaController extends Controller
{
    public function index()
    {

        $diretorias = Diretoria::all();

        return view('diretoria.index', compact('diretorias'));
    }

    public function create()
    {
        $diretoria = new Diretoria;

        return view('diretoria.diretoria-forms.create', compact('diretoria'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'sigla' => ['required', 'string', 'max:20', 'unique:diretorias,sigla'],
            'status' => ['required', 'in:ativo,inativo'],
        ]);

        Diretoria::create($validated);

        return redirect()->route('diretoria.index')->with('sucess', 'Nova diretoria salva com sucesso.');
    }

    public function destroy($id)
    {

        $diretoria = Diretoria::findOrFail($id);

        $diretoria->delete();

        return redirect()->route('diretoria.index')->with('success', 'Diretoria excluida com sucesso.');
    }

    public function edit($id)
    {
        $diretoria = Diretoria::findOrFail($id);

        return view('diretoria.diretoria-forms.create', compact('diretoria'));
    }

    public function update(Request $request, $id)
    {

        $diretoria = Diretoria::findOrFail($id);

        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'sigla' => ['required', 'string', 'max:20', Rule::unique('diretorias', 'sigla')->ignore($diretoria->id)],
            'status' => ['required', 'in:ativo,inativo'],
        ]);

        $diretoria->update($validated);

        return redirect()->route('diretoria.index')->with('success', 'Diretoria atualizada com sucesso.');
    }
}
