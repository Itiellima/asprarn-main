<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinanceiroContaBancaria;
use Illuminate\Support\Facades\Http;

class ContasBancariasController extends Controller
{
    public function index()
    {
        $contasBancarias = FinanceiroContaBancaria::all();

        return view('financeiro.contas_bancarias', compact('contasBancarias'));
    }

    public function create()
    {

        $response = Http::get('https://brasilapi.com.br/api/banks/v1');

        $bancos = collect($response->json());

        $codigosPrincipais = [
            1,   // Banco do Brasil
            104, // Caixa
            237, // Bradesco
            341, // Itaú
            33,  // Santander
            260, // Nubank
            77,  // Inter
            336, // C6 Bank
            323, // Mercado Pago
            290, // PagBank
            380, // PicPay
            756, // Sicoob
            748, // Sicredi
        ];

        $bancos = $bancos
            ->whereIn('code', $codigosPrincipais)
            ->sortBy('code')
            ->values();

        return view('financeiro.contas_bancarias.create', compact('bancos'));
    }
}
