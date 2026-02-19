<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opm;
use Illuminate\Support\Facades\Auth;

class OpmController extends Controller
{
    //

    public function store(Request $request)
    {

        $user = Auth::user();

        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:500',
            'status' => 'nullable|string|max:50',
        ]);

        Opm::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'status' => $request->status,
        ]);

        return redirect()->route('configuracoes.index')->with('success', 'OPM criada com sucesso!');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('admin|moderador')){
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $opm = Opm::findOrFail($id);
        $opm->delete();

        return redirect()->route('configuracoes.index')->with('success', 'OPM deletada com sucesso!');
    }
}
