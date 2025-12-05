<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Associado;
use App\Models\Situacao;

class SituacaoController extends Controller
{

    // Para referencia
    public function storeSituacao(Request $request, $id) {

        $user = Auth::user();

        if(!$user || !$user->hasAnyRole(['admin', 'moderador'])){
            return redirect()->back()->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $validated = $request->validate([
            'ativo' => 'nullable|boolean',
            'inadimplente' => 'nullable|boolean',
            'pendente_documento' => 'nullable|boolean',
            'pendente_financeiro' => 'nullable|boolean',
        ]);

        $associado = Associado::findOrFail($id);

        $validated = array_merge([
            'ativo' => 0,
            'inadimplente' => 0,
            'pendente_documento' => 0,
            'pendente_financeiro' => 0,
        ], $validated);

        $associado->situacao()->updateOrCreate(
            ['associado_id' => $id],
            $validated
        );
        
        return redirect()->back()->with('success', 'Situação salva com sucesso!');
    }

    // Criar nova situacao
    public function store(Request $request)
    {
        $user = Auth::user();
        if(!$user || !$user->hasAnyRole(['admin', 'moderador'])){
            return redirect()->back()->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        Situacao::create([
            'nome' => $request->input('nome'),
        ]);

        return redirect()->back()->with('success', 'Situação criada com sucesso!');
    }

    public function update(Request $request, $associadoId)
    {
        $user = Auth::user();
        if(!$user || !$user->hasAnyRole(['admin', 'moderador'])){
            return redirect()->back()->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        // Verifica se o associado existe
        $associado = Associado::findOrFail($associadoId);

        $situacoes = $request->input('situacoes', []);

        $associado->situacoes()->sync($situacoes);

        return redirect()->back()->with('success', 'Situação atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if(!$user || !$user->hasAnyRole(['admin', 'moderador'])){
            return redirect()->back()->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $situacao = Situacao::findOrFail($id);

        $situacao->delete();

        return redirect()->back()->with('success', 'Situação excluída com sucesso!');
    }

    public function edit(Request $request, $id)
    {
        $user = Auth::user();
        if(!$user || !$user->hasAnyRole(['admin', 'moderador'])){
            return redirect()->back()->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $situacao = Situacao::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $situacao->update([
            'nome' => $request->input('nome'),
        ]);


        return redirect()->back()->with('success', 'Situação atualizada com sucesso!');
    }

}
