<?php

namespace App\Http\Controllers\Diretoria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diretoria;

class DiretoriaController extends Controller
{
    public function index()
    {

        $diretorias = Diretoria::all();

        return view('diretoria.index', compact('diretorias'));
    }

    public function create()
    {
        $diretoria = new Diretoria;

        return view('diretoria.diretoria-forms.create', compact('diretoria'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'sigla' => ['required', 'string', 'max:20', 'unique:diretorias,sigla'],
            'status' => ['required', 'in:ativo,inativo'],
        ]);

        Diretoria::create($validated);

        return redirect()->route('diretoria.index');
    }
}
