<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinanceiroContaBancaria;

class ContasBancariasController extends Controller
{
    public function index()
    {
        $contasBancarias = FinanceiroContaBancaria::all();
    
        return view('financeiro.contas_bancarias', compact('contasBancarias'));
    }

    public function create()
    {
        return view('financeiro.contas_bancarias.create');
    }
}
