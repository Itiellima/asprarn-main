<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinanceiroContaBancaria;
use Exception;
use Illuminate\Support\Facades\Http;

class ContasBancariasController extends Controller
{
    public function index()
    {
        $contas = FinanceiroContaBancaria::all();

        return view('financeiro.contas_bancarias', compact('contas'));
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

        $conta = new FinanceiroContaBancaria();


        return view('financeiro.contas_bancarias.create', compact('bancos', 'conta'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'tipo' => ['required', 'string', 'max:255'],
            'banco' => ['required', 'integer'],
            'agencia' => ['required', 'string', 'max:20'],
            'conta' => ['required', 'string', 'max:20'],
            'descricao' => ['nullable', 'string', 'max:255']
        ]);

        try {
            FinanceiroContaBancaria::create($validated);
        } catch (Exception $e) {
            return redirect()->back()->with('error', '$e');
        };

        return redirect()->route('financeiro.contas_bancarias')->with('success', 'Conta Bancaria cadastrada com sucesso!');
    }

    public function edit($id)
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

        $conta = FinanceiroContaBancaria::findOrFail($id);


        return view('financeiro.contas_bancarias.create', compact('conta', 'bancos'));
    }
}
