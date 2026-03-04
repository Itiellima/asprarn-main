<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrestadorDeServicoAutonomo;
use Illuminate\Support\Facades\Auth;

class PrestadorDeServicosController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $prestadores = PrestadorDeServicoAutonomo::all();

        return view('prestador-de-servicos-autonomos.index', compact('prestadores'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $prestador = new PrestadorDeServicoAutonomo();

        return view('prestador-de-servicos-autonomos.create', compact('prestador'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:prestador_de_servicos_autonomos,cpf',
        ]);


        PrestadorDeServicoAutonomo::create($request->only([
            'nome',
            'cpf',
            'rg',
            'empresa',
            'funcao',
            'departamento',
            'atividade',
            'email_pessoal',
            'email_profissional',
            'telefone_1',
            'telefone_2',
            'endereco',
            'data_admissao',
            'data_demissao',
            'observacoes'
        ]));

        return redirect()->route('prestador-de-servicos-autonomos.index')->with('success', 'Prestador de serviço criado com sucesso.');
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $prestador = PrestadorDeServicoAutonomo::findOrFail($id);

        return view('prestador-de-servicos-autonomos.edit', compact('prestador'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $prestador = PrestadorDeServicoAutonomo::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:prestador_de_servicos_autonomos,cpf,' . $prestador->id,
        ]);

        $prestador->update($request->only([
            'nome',
            'cpf',
            'rg',
            'empresa',
            'funcao',
            'departamento',
            'atividade',
            'email_pessoal',
            'email_profissional',
            'telefone_1',
            'telefone_2',
            'endereco',
            'data_admissao',
            'data_demissao',
            'observacoes'
        ]));

        return redirect()->route('prestador-de-servicos-autonomos.index')->with('success', 'Prestador de serviço atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $prestador = PrestadorDeServicoAutonomo::findOrFail($id);
        $prestador->delete();

        return redirect()->route('prestador-de-servicos-autonomos.index')->with('success', 'Prestador de serviço excluído com sucesso.');
    }

}
