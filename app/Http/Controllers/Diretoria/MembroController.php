<?php

namespace App\Http\Controllers\Diretoria;

use App\Http\Controllers\Controller;
use App\Models\Associado;
use App\Models\Diretoria;
use App\Models\DiretoriaFuncao;
use App\Models\DiretoriaMembro;
use Exception;
use Illuminate\Http\Request;

class MembroController extends Controller
{
    public function index()
    {
        $membros = DiretoriaMembro::with([
            'associado',
            'funcao',
            'diretoria'
        ])->get();

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

    public function store(Request $request)
    {

        $validated = $request->validate([
            'associado' => ['required', 'exists:associados,id'],
            'diretoria' => ['required', 'exists:diretorias,id'],
            'funcao' => ['required', 'exists:diretoria_funcoes,id'],
            'inicio_mandato' => ['nullable', 'date'],
            'fim_mandato' => ['nullable', 'date'],
        ]);

        try {
            DiretoriaMembro::create([
                'associado_id' => $validated['associado'],
                'diretoria_id' => $validated['diretoria'],
                'diretoria_funcoes_id' => $validated['funcao'],
                'inicio_mandato' => $validated['inicio_mandato'] ?? null,
                'fim_mandato' => $validated['fim_mandato'] ?? null,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('diretoria.membros.index')->with('error', 'Erro ao cadastrar novo membro. ' . $e->getMessage());
        }

        return redirect()->route('diretoria.membros.index')->with('success', 'Novo membro criado com sucesso.');
    }

    public function destroy($id)
    {
        $membro = DiretoriaMembro::findOrFail($id);

        $membro->delete();

        return redirect()->route('diretoria.membros.index')->with('success', 'Membro excluido com sucesso.');
    }

    public function edit($id) 
    {
        $membro = DiretoriaMembro::findOrFail($id);
        
        $associados = Associado::all();

        $diretorias = Diretoria::all();

        $funcoes = DiretoriaFuncao::all();

        return view('diretoria.membros.create', compact('membro', 'associados', 'diretorias', 'funcoes'));
    }

    public function update(Request $request, $id)
    {
        $membro = DiretoriaMembro::findOrFail($id);

        $validated = $request->validate([
            'associado' => ['required', 'exists:associados,id'],
            'diretoria' => ['required', 'exists:diretorias,id'],
            'funcao' => ['required', 'exists:diretoria_funcoes,id'],
            'inicio_mandato' => ['nullable', 'date'],
            'fim_mandato' => ['nullable', 'date', 'after_or_equal:inicio_mandato'],
        ]);

        try {
            $membro->update([
                'associado_id' => $validated['associado'],
                'diretoria_id' => $validated['diretoria'],
                'diretoria_funcoes_id' => $validated['funcao'],
                'inicio_mandato' => $validated['inicio_mandato'] ?? null,
                'fim_mandato' => $validated['fim_mandato'] ?? null,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('diretoria.membros.index')->with('error', 'Erro ao cadastrar novo membro. ' . $e->getMessage());
        }

        return redirect()->route('diretoria.membros.index')->with('success', 'Membro atualizado com sucesso.');
    }
}
