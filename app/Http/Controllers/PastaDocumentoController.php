<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PastaDocumentoController extends Controller
{
    public function index($associadoId)
    {
        $associado = Associado::findOrFail($associadoId);

        $pastas = $associado->pastaDocumentos()
            ->with('files')
            ->paginate(10);


        return view('associado.pastas.index', compact('associado', 'pastas'));
    }

    public function store(Request $request, $associadoId)
    {
        $associado = Associado::findOrFail($associadoId);

        $request->validate([
            'nome' => 'required|string|max:255',
            'tipo_documento' => 'nullable|string|max:100',
            'descricao' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try{
            // Criar a pasta de documentos associada ao associado
            $associado->pastaDocumentos()->create([
                'nome' => $request->nome,
                'tipo_documento' => $request->tipo_documento,
                'descricao' => $request->descricao,
            ]);
    
            DB::commit();
            return redirect()->back()->with('success', 'Pasta de documentos criada com sucesso.');
        } catch (\Exception $e){
            DB::rollBack();
            report($e); // detalhe técnico vai para o log, não para a tela
            return redirect()->back()->with('error', 'Erro ao criar a pasta de documentos. Tente novamente.');
        }
    }

    public function show($associadoId, $pastaId)
    {
        $associado = Associado::findOrFail($associadoId);
        $pasta = $associado->pastaDocumentos()->findOrFail($pastaId);

        $search = request('search');

        $documentos = $pasta->files()
            ->when($search, function ($query, $search) {
                // Agrupado para os orWhere não escaparem do filtro da pasta
                $query->where(function ($q) use ($search) {
                    $q->where('tipo_documento', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhere('observacao', 'like', "%{$search}%");
                });
            })
            ->paginate(10)
            ->withQueryString();

        return view('associado.pastas.show', compact('pasta', 'associado', 'documentos', 'search'));
    }

    public function destroy($associadoId, $pastaId){
        $associado = Associado::findOrFail($associadoId);
        $pasta = $associado->pastaDocumentos()->findOrFail($pastaId);

        DB::beginTransaction();
        try{
            // O model PastaDocumento apaga os registros dos arquivos, e o model File
            // só apaga do bucket depois do commit (se der rollback, nada se perde)
            $pasta->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Pasta excluída com sucesso.');
        } catch (\Exception $e){
            DB::rollBack();
            report($e); // detalhe técnico vai para o log, não para a tela
            return redirect()->back()->with('error', 'Erro ao excluir a pasta. Tente novamente.');
        }
    }

}
