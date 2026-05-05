<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcaoJudicial;

class AcaoJudicialController extends Controller
{
    //
    public function index()
    {
        $acoes = AcaoJudicial::all();

        return view('acao-judicial.index', compact('acoes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        AcaoJudicial::create([
            'nome' => $request->nome,
        ]);


        return redirect()->route('acao-judicial.index');
    }
}
