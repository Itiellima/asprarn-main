<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Situacao;

class ConfiguracoesController extends Controller
{
    
    public function index()
    {

        $situacoes = Situacao::all();

        return view('configuracoes.index', compact('situacoes'));
    }
}
