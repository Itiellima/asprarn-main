<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use App\Models\Plano;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;

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


    public function index()
    {
        $user = Auth::user();
        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])){
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $planos = Plano::all();

        return view('planos.index', compact('planos'));
    }

    
    public function create(){

        $user = Auth::user();
        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])){
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $plano = new Plano();

        return view('planos.create', compact('plano'));
    }


    // Cria um novo plano
    public function store(Request $request){

        $user = Auth::user();
        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])){
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'beneficios.*' => 'required|string|max:500',
            'descricao' => 'required|string|max:500',
            'preco' => 'required|numeric|min:0'
        ], [
            'beneficios.*.max' => 'Cada item da descrição não pode exceder 500 caracteres.',
            'descricao.max' => 'Descrição não pode exceder 500 caracteres.',
        ]);
        
        DB::beginTransaction();
        try{
            $plano = Plano::create( $request->only([
                'nome',
                'beneficios',
                'descricao',
                'preco'
            ]));

            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Erro ao criar o plano');
        }

        return redirect()->route('planos.index')->with('success', 'Plano associado com sucesso!');
    }

    public function destroy($id){
        $user = Auth::user();
        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])){
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $plano = Plano::findOrFail($id);
        $plano->delete();

        return redirect()->route('planos.index')->with('success', 'Plano deletado com sucesso!');
    }
}
