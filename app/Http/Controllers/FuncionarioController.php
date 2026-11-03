<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
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

    public function store(Request $request)
    {
        $request->merge([
            'cpf' => preg_replace('/[^0-9]/', '', $request->cpf),
            'telefone_1' => preg_replace('/[^0-9]/', '', $request->telefone_1),
            'telefone_2' => preg_replace('/[^0-9]/', '', $request->telefone_2),
        ]);

        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:funcionarios,cpf',
        ], [
            'cpf.unique' =>'Já existe um funcionario com esse CPF cadastrado.'
        ]);

        Funcionario::create($request->only([
            'nome',
            'cpf',
            'rg',
            'pis',
            'ctps',
            'empresa',
            'funcao',
            'departamento',
            'atividade',
            'horario_trabalho',
            'email_pessoal',
            'email_profissional',
            'telefone_1',
            'telefone_2',
            'endereco',
            'data_admissao',
            'data_demissao',
            'observacoes'
        ]));

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

    public function update(Request $request, $id)
    {
        $funcionario = Funcionario::findOrFail($id);

        $request->merge([
            'cpf' => preg_replace('/[^0-9]/', '', $request->cpf),
            'telefone_1' => preg_replace('/[^0-9]/', '', $request->telefone_1),
            'telefone_2' => preg_replace('/[^0-9]/', '', $request->telefone_2),
        ]);


        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:funcionarios,cpf,' . $funcionario->id,
        ], [
            'cpf.unique' =>'Já existe um funcionario com esse CPF cadastrado.'
        ]);

        $funcionario->update($request->only([
            'nome',
            'cpf',
            'rg',
            'pis',
            'ctps',
            'empresa',
            'funcao',
            'departamento',
            'atividade',
            'horario_trabalho',
            'email_pessoal',
            'email_profissional',
            'telefone_1',
            'telefone_2',
            'endereco',
            'data_admissao',
            'data_demissao',
            'observacoes'
        ]));

        return redirect()->route('funcionarios.index')->with('success', 'Funcionário atualizado com sucesso.');
    }
}
