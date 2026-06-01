<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcaoJudicial;
use Illuminate\Support\Facades\Auth;
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

        $user = Auth::user();

        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

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
        $user = Auth::user();

        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $acao = AcaoJudicial::findOrFail($id);
        $acao->delete();

        return redirect()->route('configuracoes.index')->with('success', 'Ação Judicial deletada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

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
        $user = Auth::user();

        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

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
