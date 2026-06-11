<?php

namespace App\Http\Controllers\Diretoria;

use App\Http\Controllers\Controller;
use App\Models\Associado;
use App\Models\Diretoria;
use App\Models\DiretoriaFuncao;
use App\Models\DiretoriaMembro;
use Illuminate\Http\Request;

class MembroController extends Controller
{
    public function index()
    {
        $membros = DiretoriaMembro::all();

        return view('diretoria.membros.index', compact('membros'));
    }

    public function create()
    {
        $membro = new DiretoriaMembro();

        $associados = Associado::all();

        $diretorias = Diretoria::all();

        $funcoes = DiretoriaFuncao::all();

        return view('diretoria.membros.create', compact('membro', 'associados', 'diretorias', 'funcoes'));
    }
}
