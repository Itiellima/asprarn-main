<?php

namespace App\Http\Controllers\Associado;

use App\Http\Controllers\Controller;
use App\Models\Associado;
use App\Models\Opm;
use App\Services\IbgeService;
use Illuminate\Support\Facades\Gate;

/** "Meus Dados": a ficha do associado vista por ele mesmo (ou por admin/moderador) */
class InformacoesController extends Controller
{
    public function show($id, IbgeService $ibge)
    {
        $associado = Associado::findOrFail($id);
        Gate::authorize('view', $associado);

        $ufs = $ibge->estados();
        $opms = Opm::orderBy('nome')->get();

        return view('dashboard.associadoComponents.associado-informacoes', compact('associado', 'ufs', 'opms'));
    }
}
