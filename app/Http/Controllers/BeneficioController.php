<?php

namespace App\Http\Controllers;

use App\Models\Beneficio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class BeneficioController extends Controller
{
    public function index()
    {

        $beneficios = Beneficio::all();

        return view('beneficio.index', compact('beneficios'));
    }

    public function create()
    {

        $user = Auth::user();

        if(!$user || !$user->hasAnyRole(['admin', 'moderador'])){
            return redirect('beneficio')->with('error', 'Acesso negado. Você não tem acesso a essa funcionalidade.');
        }

        $beneficio = new Beneficio();

        return view('beneficio.create', compact('beneficio'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'nome' => 'required',
            'descricao' => 'required',
            'arquivos' => 'required',
        ]);

        $arquivos = $request->file('arquivos');

        DB::beginTransaction();
        try {
            $beneficio = Beneficio::create([
                'nome' => $request->nome,
                'descricao' => $request->descricao,
            ]);

            foreach ($arquivos as $arquivo) {
                $path = $arquivo->store('img', 'public');

                $beneficio->files()->create([
                    'path' => $path,
                    'tipo_documento' => 'imagem',
                    'status' => 'ativo',
                    'observacao' => 'Upload automatico',
                ]);
            }

            DB::commit();

            return redirect('beneficio')->with('success', 'Beneficio criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('beneficio')->with('error', 'Erro ao criar beneficio!' . $e->getMessage());
        }
    }


    public function edit(Beneficio $beneficio)
    {
        return view('beneficio.edit', compact('beneficio'));
    }

    public function update(Request $request, $id)
    {

        $user = Auth::user();

        if(!$user || !$user->hasAnyRole(['admin', 'moderador'])){
            return redirect('beneficio')->with('error', 'Acesso negado. Você nãso tem acesso a essa funcionalidade.');
        }

        $beneficio = Beneficio::findOrFail($id);

        $request->validate([
            'nome' => 'required',
            'descricao' => 'required',
            'arquivos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();
        try {

            $beneficio->update([
                'nome' => $request->nome,
                'descricao' => $request->descricao,
            ]);

            if ($request->hasFile('arquivos')) {
                foreach ($beneficio->files as $file) {
                    if (Storage::disk('public')->exists($file->path)) {
                        Storage::disk('public')->delete($file->path);
                    }
                }
                $beneficio->files()->delete();
            }

            if ($request->hasFile('arquivos')) {
                foreach ($request->file('arquivos') as $arquivo) {
                    $path = $arquivo->store('img', 'public');

                    $beneficio->files()->create([
                        'path' => $path,
                        'tipo_documento' => 'imagem',
                        'status' => 'ativo',
                        'observacao' => 'Upload automatico',
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('beneficio')->with('error', 'Erro ao atualizar beneficio!' . $e->getMessage());
        }

        return redirect()->route('beneficio.index')->with('success', 'Beneficio atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        if(!$user || !$user->hasAnyRole(['admin', 'moderador'])){
            return redirect('beneficio')->with('error', 'Acesso negado. Voçê não tema acesso a essa funcionalidade.');
        }

        $beneficio = Beneficio::findOrFail($id);

        DB::beginTransaction();
        try {

            foreach ($beneficio->files as $file) {
                Storage::disk('public')->delete($file->path);
            }
    
            $beneficio->files()->delete();
    
            $beneficio->delete();
    
            DB::commit();
            return redirect('beneficio')->with('success', 'Beneficio excluido com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('beneficio')->with('error', 'Erro ao excluir beneficio!');
        }
    }
}
