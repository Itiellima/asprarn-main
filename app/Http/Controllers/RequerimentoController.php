<?php

namespace App\Http\Controllers;

use App\Models\Associado;


class RequerimentoController extends Controller
{
    // Os documentos são páginas HTML impressas pelo navegador (resources/views/associado/pdf)
    public function show($id)
    {
        $associado = Associado::findOrFail($id);

        return view('associado.pdf.requerimento', compact('associado'));
    }

    public function sesc($id)
    {
        $associado = Associado::findOrFail($id);

        return view('associado.pdf.declaracao-sesc', compact('associado'));
    }

    public function unp($id)
    {
        $associado = Associado::findOrFail($id);

        return view('associado.pdf.unp', compact('associado'));
    }

    public function declaracao($id)
    {
        $associado = Associado::findOrFail($id);

        return view('associado.pdf.declaracao-generica', compact('associado'));
    }

    public function desfiliacao($id)
    {
        $associado = Associado::findOrFail($id);

        return view('associado.pdf.desfiliacao', compact('associado'));
    }

    public function termoDeAdesaoAcp($id)
    {
        $associado = Associado::findOrFail($id);

        return view('associado.pdf.termo-de-adesao-acp', compact('associado'));
    }

    public function beneficiariosProcuracao($id)
    {
        $associado = Associado::findOrFail($id);

        return view('associado.pdf.beneficiarios-procuracao', compact('associado'));
    }

    public function declaracaoAssociadoPromocao($id)
    {
        $associado = Associado::findOrFail($id);

        return view('associado.pdf.declaracao-associado-promocao', compact('associado'));
    }
}