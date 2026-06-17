<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerguntasFrequentesController extends Controller
{
    public function index()
    {
        return view('perguntas_frequentes.index');
    }
}
