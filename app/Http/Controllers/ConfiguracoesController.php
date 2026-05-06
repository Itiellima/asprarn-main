<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Situacao;
use App\Models\Opm;
use App\Models\AcaoJudicial;
use Illuminate\Support\Facades\Auth;

class ConfiguracoesController extends Controller
{
    
    public function index()
    {

        $user = Auth::user();

        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $situacoes = Situacao::all();

        $acoes = AcaoJudicial::all();

        $opms = Opm::orderBy('nome', 'asc')->get();

        return view('configuracoes.index', compact('situacoes', 'opms', 'acoes'));
    }
}
