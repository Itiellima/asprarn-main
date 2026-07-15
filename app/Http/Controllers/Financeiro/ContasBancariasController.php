<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinanceiroContaBancaria;
use Exception;
use Illuminate\Support\Facades\Http;
use App\Services\ListarBancosService;


class ContasBancariasController extends Controller
{
    public function index()
    {
        $contas = FinanceiroContaBancaria::all();

        return view('financeiro.contas_bancarias.index', compact('contas'));
    }

    public function create(ListarBancosService $ListarBancosService)
    {

        $bancos = $ListarBancosService->listarPrincipais();


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

        return redirect()->route('financeiro.contas_bancarias.index')->with('success', 'Conta Bancaria cadastrada com sucesso!');
    }

    public function edit($id, ListarBancosService $ListarBancosService)
    {

        $bancos = $ListarBancosService->listarPrincipais();

        $conta = FinanceiroContaBancaria::findOrFail($id);


        return view('financeiro.contas_bancarias.create', compact('conta', 'bancos'));
    }

    public function update(Request $request, $id)
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
            $conta = FinanceiroContaBancaria::findOrFail($id);
            $conta->update($validated);
        } catch (Exception $e) {
            return redirect()->back()->with('error', '$e');
        };

        return redirect()->route('financeiro.contas_bancarias.index')->with('success', 'Conta Bancaria atualizada com sucesso!');
    }

    public function destroy($id)
    {
        try {
            $conta = FinanceiroContaBancaria::findOrFail($id);
            $conta->delete();
        } catch (Exception $e) {
            return redirect()->back()->with('error', '$e');
        };

        return redirect()->route('financeiro.contas_bancarias.index')->with('success', 'Conta Bancaria excluída com sucesso!');
    }
}
