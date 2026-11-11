<?php

namespace App\Http\Controllers;

use App\Http\Requests\FuncionarioRequest;
use App\Models\Funcionario;

class FuncionarioController extends Controller
{
    //
    public function index()
    {
        $funcionarios = Funcionario::all();

        return view('funcionarios.index', compact('funcionarios'));
    }

    public function create()
    {
        $funcionario = new Funcionario();

        return view('funcionarios.create', compact('funcionario'));
    }

    public function store(FuncionarioRequest $request)
    {
        Funcionario::create($request->only(FuncionarioRequest::CAMPOS));

        return redirect()->route('funcionarios.index')->with('success', 'Funcionário criado com sucesso.');
    }

    public function show($id)
    {
        $funcionario = Funcionario::findOrFail($id);

        return view('funcionarios.show', compact('funcionario'));
    }

    public function destroy($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        $funcionario->delete();

        return redirect()->route('funcionarios.index')->with('success', 'Funcionário excluído com sucesso.');
    }

    public function update(FuncionarioRequest $request, $id)
    {
        $funcionario = Funcionario::findOrFail($id);

        $funcionario->update($request->only(FuncionarioRequest::CAMPOS));

        return redirect()->route('funcionarios.index')->with('success', 'Funcionário atualizado com sucesso.');
    }
}
