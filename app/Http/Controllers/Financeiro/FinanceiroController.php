<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinanceiroCategoria;

class FinanceiroController extends Controller
{
    public function index()
    {
        return view('financeiro.index');
    }

}
