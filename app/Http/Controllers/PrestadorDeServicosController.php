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
        if (!$user || !$user->hasRole('admin')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $prestadores = PrestadorDeServicoAutonomo::all();

        return view('prestador-de-servicos-autonomos.index', compact('prestadores'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }
        return view('prestador-de-servicos-autonomos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:prestadores_de_servicos,cpf',
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
}
