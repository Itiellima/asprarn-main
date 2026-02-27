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
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $funcionarios = Funcionario::all();


        return view('funcionarios.index', compact('funcionarios'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $funcionario = new Funcionario();


        return view('funcionarios.create', compact('funcionario'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

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
}
