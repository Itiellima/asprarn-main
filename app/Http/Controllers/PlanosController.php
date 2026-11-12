<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanoRequest;
use App\Models\Plano;

class PlanosController extends Controller
{
    public function index()
    {
        $planos = Plano::all();

        return view('planos.index', compact('planos'));
    }

    public function create()
    {
        $plano = new Plano();

        return view('planos.create', compact('plano'));
    }

    public function store(PlanoRequest $request)
    {
        try {
            Plano::create($request->only(PlanoRequest::CAMPOS));
        } catch (\Exception $e) {
            report($e); // detalhe técnico vai para o log, não para a tela
            return redirect()->back()->withInput()->with('error', 'Erro ao criar o plano. Tente novamente.');
        }

        return redirect()->route('planos.index')->with('success', 'Plano criado com sucesso!');
    }

    public function edit($id)
    {
        $plano = Plano::findOrFail($id);

        return view('planos.create', compact('plano'));
    }

    public function update(PlanoRequest $request, $id)
    {
        $plano = Plano::findOrFail($id);

        try {
            $plano->update($request->only(PlanoRequest::CAMPOS));
        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->withInput()->with('error', 'Erro ao atualizar o plano. Tente novamente.');
        }

        return redirect()->route('planos.index')->with('success', 'Plano atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $plano = Plano::findOrFail($id);
        $plano->delete();

        return redirect()->route('planos.index')->with('success', 'Plano excluído com sucesso!');
    }
}
