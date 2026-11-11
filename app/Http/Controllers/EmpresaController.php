<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpresaRequest;
use App\Models\Empresa;

class EmpresaController extends Controller
{
    //
    public function index()
    {
        $empresas = Empresa::all();

        return view('empresas.index', compact('empresas'));
    }

    public function create()
    {
        $empresa = new Empresa();

        return view('empresas.create', compact('empresa'));
    }

    public function store(EmpresaRequest $request)
    {
        Empresa::create($request->only(EmpresaRequest::CAMPOS));

        return redirect()->route('empresas.index')->with('success', 'Empresa criada com sucesso.');
    }

    public function show($id)
    {
        $empresa = Empresa::findOrFail($id);

        return view('empresas.show', compact('empresa'));
    }

    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->delete();

        return redirect()->route('empresas.index')->with('success', 'Empresa excluída com sucesso.');
    }

    public function update(EmpresaRequest $request, $id)
    {
        $empresa = Empresa::findOrFail($id);

        $empresa->update($request->only(EmpresaRequest::CAMPOS));

        return redirect()->route('empresas.index')->with('success', 'Empresa atualizada com sucesso.');
    }
}
