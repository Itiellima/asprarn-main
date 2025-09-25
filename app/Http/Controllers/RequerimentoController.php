<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use Illuminate\Support\Facades\Auth;


class RequerimentoController extends Controller
{
    /* 
    public function gerar($id)
    {
        $associado = Associado::findOrFail($id);

        $pdf = Pdf::loadView('associado.pdf.requerimento', compact('associado'))
                  ->setPaper('a4');

        return $pdf->stream('requerimento_'.$associado->nome.'.pdf');
    }
        */

    public function show($id)
    {

        $user = Auth::user();

        if(!$user || !$user->hasAnyRole(['admin', 'moderador'])){
            return redirect()->back()->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $associado = Associado::findOrFail($id);

        return view('associado.pdf.requerimento', compact('associado'));
    }
}
