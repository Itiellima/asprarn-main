<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Associado;
use App\Models\Situacao;

class RelatorioController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $associados = Associado::with([
            'situacoes',
        ])->get();

        $situacoes = Situacao::all();


        return view('relatorios.index', compact('associados', 'situacoes'));
    }

    public function gerarRelatorio(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }


        $associados = Associado::query()
            ->when(request('situacao_id'), function ($query, $situacao_id) {
                $query->whereHas('situacoes', function ($q) use ($situacao_id) {
                    $q->whereKey($situacao_id);
                });
            })
            ->with('situacoes')
            ->get();

        return view('relatorios.gerar', compact('associados'));
    }
}
