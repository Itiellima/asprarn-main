<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Associado;
use App\Models\Situacao;

class SituacaoController extends Controller
{

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



}
