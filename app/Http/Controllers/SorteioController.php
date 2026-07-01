<?php

namespace App\Http\Controllers;

use App\Models\Sorteio;
use App\Models\SorteioParticipante;
use App\Models\SorteioResultado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SorteioController extends Controller
{

    public function index()
    {
        $sorteios = Sorteio::latest()->get();

        return view('sorteios.index', compact('sorteios'));
    }


    public function create()
    {
        return view('sorteios.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero' => ['required', 'unique:sorteios,numero'],
            'descricao' => ['required'],
            'data_sorteio' => ['required', 'date'],
            // 'quantidade_ganhadores' => ['required', 'integer', 'min:1'],
        ]);


        Sorteio::create($validated);


        return redirect()
            ->route('sorteios.index')
            ->with('success', 'Sorteio criado com sucesso.');
    }



    public function show($id)
    {

        $sorteio = Sorteio::with([
            'participantes',
            'resultados.participante'
        ])->findOrFail($id);

        $resultados = $sorteio->resultados()
            ->orderBy('posicao')
            ->get();

        return view('sorteios.show', compact('sorteio', 'resultados'));
    }




    public function adicionarParticipante(Request $request, $id)
    {

        $request->validate([
            'nome' => ['required'],
            'cpf' => ['required'],
        ]);


        SorteioParticipante::create([
            'sorteio_id' => $id,

            'associado_id' => $request->associado_id,

            'nome' => $request->nome,

            'cpf' => $request->cpf,
        ]);


        return back()
            ->with('success', 'Participante adicionado.');
    }





    // public function sortear($id)
    // {

    //     $sorteio = Sorteio::findOrFail($id);


    //     $jaSorteados = $sorteio->resultados()
    //         ->pluck('sorteio_participante_id');


    //     $participantes = $sorteio->participantes()
    //         ->whereNotIn('id', $jaSorteados)
    //         ->inRandomOrder()
    //         ->limit($sorteio->quantidade_ganhadores)
    //         ->get();



    //     if ($participantes->count() == 0) {

    //         return back()
    //             ->with('error', 'Não existem participantes disponíveis.');
    //     }



    //     DB::transaction(function () use ($participantes, $sorteio) {


    //         $posicao = 1;


    //         foreach ($participantes as $participante) {


    //             SorteioResultado::create([

    //                 'sorteio_id' => $sorteio->id,

    //                 'sorteio_participante_id' => $participante->id,

    //                 'posicao' => $posicao++,

    //             ]);
    //         }


    //         $sorteio->update([
    //             'status' => 'finalizado'
    //         ]);
    //     });



    //     return back()
    //         ->with('success', 'Sorteio realizado.');
    // }

    public function sortear($id)
    {
        $sorteio = Sorteio::with('participantes')->findOrFail($id);

        // já sorteados
        $jaSorteados = $sorteio->resultados()
            ->pluck('sorteio_participante_id')
            ->toArray();

        // pega quem ainda não foi sorteado
        $disponiveis = $sorteio->participantes
            ->whereNotIn('id', $jaSorteados)
            ->values();

        // se não tiver mais ninguém
        if ($disponiveis->isEmpty()) {
            return redirect()->back()
                ->with('error', 'Todos os participantes já foram sorteados.');
        }

        // sorteia 1 pessoa
        $sorteado = $disponiveis->random();

        // define próxima posição
        $posicao = $sorteio->resultados()->count() + 1;

        // salva resultado
        SorteioResultado::create([
            'sorteio_id' => $sorteio->id,
            'sorteio_participante_id' => $sorteado->id,
            'posicao' => $posicao,
        ]);

        return redirect()->back()
            ->with('success', "Sorteado: {$sorteado->nome}");
    }





    public function destroy($id)
    {

        $sorteio = Sorteio::findOrFail($id);

        $sorteio->delete();


        return back()
            ->with('success', 'Sorteio removido.');
    }
}
