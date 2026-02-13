<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Situacao;
use App\Models\Opm;

class ConfiguracoesController extends Controller
{
    
    public function index()
    {

        $situacoes = Situacao::all();

        $opms = Opm::all();

        return view('configuracoes.index', compact('situacoes', 'opms'));
    }
}
