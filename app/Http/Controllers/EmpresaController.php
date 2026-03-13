<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\support\Facades\Auth;


class EmpresaController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $empresas = Empresa::all();


        return view('empresas.index', compact('empresas'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $empresa = new Empresa();


        return view('empresas.create', compact('empresa'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $request->merge([
            'cnpj' => preg_replace('/[^0-9]/', '', $request->cnpj),
            'telefone' => preg_replace('/[^0-9]/', '', $request->telefone),
            'telefone_2' => preg_replace('/[^0-9]/', '', $request->telefone_2),
        ]);

        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required|string|max:14',
        ], [
            'cnpj.unique' => 'Já existe uma empresa com esse CNPJ cadastrado.'
        ]);

        Empresa::create($request->only([
            'nome',
            'cnpj',
            'endereco',
            'telefone',
            'telefone_2',
            'email',
            'email_2',
            'tipo_convenio',
            'horario_trabalho',
            'data_inicio_contrato',
            'data_fim_contrato',
            'funcionarios',
            'observacoes'
        ]));

        return redirect()->route('empresas.index')->with('success', 'Empresa criada com sucesso.');
    }

    public function show($id)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $empresa = Empresa::findOrFail($id);

        return view('empresas.show', compact('empresa'));
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $empresa = Empresa::findOrFail($id);
        $empresa->delete();

        return redirect()->route('empresas.index')->with('success', 'Empresa excluído com sucesso.');
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $empresa = Empresa::findOrFail($id);

        $request->merge([
            'cnpj' => preg_replace('/[^0-9]/', '', $request->cnpj),
            'telefone' => preg_replace('/[^0-9]/', '', $request->telefone),
            'telefone_2' => preg_replace('/[^0-9]/', '', $request->telefone_2),
        ]);


        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required|string|max:14',
        ], [
            'cnpj.unique' => 'Já existe uma empresa com esse CNPJ cadastrado.'
        ]);

        $empresa->update($request->only([
            'nome',
            'cnpj',
            'endereco',
            'telefone',
            'telefone_2',
            'email',
            'email_2',
            'tipo_convenio',
            'horario_trabalho',
            'data_inicio_contrato',
            'data_fim_contrato',
            'funcionarios',
            'observacoes'
        ]));

        return redirect()->route('empresas.index')->with('success', 'Empresa atualizado com sucesso.');
    }
}
