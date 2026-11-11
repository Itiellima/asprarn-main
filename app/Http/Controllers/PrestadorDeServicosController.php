<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrestadorDeServicosRequest;
use App\Models\PrestadorDeServicoAutonomo;

class PrestadorDeServicosController extends Controller
{
    public function index()
    {
        $prestadores = PrestadorDeServicoAutonomo::all();

        return view('prestador-de-servicos-autonomos.index', compact('prestadores'));
    }

    public function create()
    {
        $prestador = new PrestadorDeServicoAutonomo();

        return view('prestador-de-servicos-autonomos.create', compact('prestador'));
    }

    public function store(PrestadorDeServicosRequest $request)
    {

        PrestadorDeServicoAutonomo::create($request->only(PrestadorDeServicosRequest::CAMPOS));

        return redirect()->route('prestador-de-servicos-autonomos.index')->with('success', 'Prestador de serviço criado com sucesso.');
    }

    public function edit($id)
    {
        $prestador = PrestadorDeServicoAutonomo::findOrFail($id);

        return view('prestador-de-servicos-autonomos.edit', compact('prestador'));
    }

    public function update(PrestadorDeServicosRequest $request, $id)
    {
        $prestador = PrestadorDeServicoAutonomo::findOrFail($id);

        $prestador->update($request->only(PrestadorDeServicosRequest::CAMPOS));

        return redirect()->route('prestador-de-servicos-autonomos.index')->with('success', 'Prestador de serviço atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $prestador = PrestadorDeServicoAutonomo::findOrFail($id);
        $prestador->delete();

        return redirect()->route('prestador-de-servicos-autonomos.index')->with('success', 'Prestador de serviço excluído com sucesso.');
    }

}
