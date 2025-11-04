<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use App\Models\Plano;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;

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


    public function index()
    {

        // $planos = Plano::findAll();

        return view('planos.index');
    }

    
    public function create(){

        // $plano = new Plano();

        return view('planos.create');
    }

    //A criar
    // Armazenar a associação do plano ao associado
    public function store(Request $request){

        $request->validate([
            'plano_id' => 'required|exists:planos,id',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'ativo' => 'required|boolean',
        ], [
            'plano_id.required' => 'O campo Plano é obrigatório.',
            'plano_id.exists' => 'O plano selecionado não existe.',
            'data_inicio.required' => 'O campo Data de Início é obrigatório.',
            'data_inicio.date' => 'O campo Data de Início deve ser uma data válida.',
            'data_fim.date' => 'O campo Data de Fim deve ser uma data válida.',
            'data_fim.after_or_equal' => 'O campo Data de Fim deve ser uma data igual ou posterior à Data de Início.',
            'ativo.required' => 'O campo Ativo é obrigatório.',
            'ativo.boolean' => 'O campo Ativo deve ser verdadeiro ou falso.',
        ]);
        

        return redirect()->route('planos.index')->with('success', 'Plano associado com sucesso!');
    }
}
