<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanosController extends Controller
{
    //

    // Associar um plano a um associado
    // $associado->planos()->attach($planoId, [
    // 'data_inicio' => now(),
    // 'ativo' => true,
    // ]); 

    // Atualizar (sem duplicar)
    // $associado->planos()->updateExistingPivot($planoId, [
    // 'data_fim' => now(),
    // 'ativo' => false,
    // ]);

    // Sincronizar planos (mantendo o estado atualizado)
    // $associado->planos()->sync([
    // $plano1_id => ['ativo' => true],
    // $plano2_id => ['ativo' => false],
    // ]);

    // Acessar os campos da pivô
    // foreach ($associado->planos as $plano) {
    // echo "{$plano->nome} - Início: {$plano->pivot->data_inicio} - Ativo: {$plano->pivot->ativo}";
    // }

    public function __boot()
    {
        $user = Auth::user();
        if (!$user || !$user->hasAnyHole(['admin', 'moderador'])){
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        // Mensagem de boas-vindas ao acessar a seção de planos
        session()->flash('success', 'Bem-vindo à seção de Planos!');
    }


    public function index($associadoId)
    {
        // verifica se o associado existe
        $associado = Associado::findOrFail($associadoId);

        return view('planos.index', compact('associado'));
    }
}
