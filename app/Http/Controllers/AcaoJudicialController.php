<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcaoJudicial;
use App\Models\Associado;

class AcaoJudicialController extends Controller
{
    //
    // public function index()
    // {
    //     $acoes = AcaoJudicial::all();

    //     return view('acao-judicial.index', compact('acoes'));
    // }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        AcaoJudicial::create([
            'nome' => $request->nome,
        ]);


        return redirect()->route('configuracoes.index')->with('success', 'Ação Judicial criada com sucesso!');
    }

    public function destroy($id)
    {
        $acao = AcaoJudicial::findOrFail($id);
        $acao->delete();

        return redirect()->route('configuracoes.index')->with('success', 'Ação Judicial deletada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $acao = AcaoJudicial::findOrFail($id);
        $acao->update([
            'nome' => $request->nome,
        ]);

        return redirect()->route('configuracoes.index')->with('success', 'Ação Judicial atualizada com sucesso!');
    }

    public function updateAcoes(Request $request, $id)
    {
        $request->validate([
            'acoes' => 'array',
            'acoes.*' => 'exists:acao_judicial,id',
        ]);

        $associado = Associado::findOrFail($id);

        $acoes = $request->input('acoes', []);

        $associado->acoesJudiciais()->sync($acoes);

        return redirect()->route('associado.show', $associado->id)->with('success', 'Ação Judicial atualizada com sucesso!');
    }
}
