<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opm;

class OpmController extends Controller
{
    //

    public function store(Request $request)
    {
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
        $opm = Opm::findOrFail($id);
        $opm->delete();

        return redirect()->route('configuracoes.index')->with('success', 'OPM deletada com sucesso!');
    }
}
