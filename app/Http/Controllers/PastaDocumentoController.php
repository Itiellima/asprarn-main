<?php

namespace App\Http\Controllers;

use App\Models\PastaDocumento;
use App\Models\Associado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PastaDocumentoController extends Controller
{
    public function index($id)
    {
        $user = Auth::user();
        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $associado = Associado::findOrFail($id);

        $pastas = PastaDocumento::with([
            'associado'
        ])
            ->paginate(10);


        return view('associado.pastas.index', compact('associado', 'pastas'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])) {
            return redirect()->route('index')->with('error', 'Acesso negado.');
        }

        $associado = Associado::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'tipo_documento' => 'nullable|string|max:100',
            'descricao' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try{
            $associado->pastaDocumentos()->create([
                'nome' => $request->nome,
                'tipo_documento' => $request->tipo_documento,
                'descricao' => $request->descricao,
            ]);
    
            DB::commit();
            return redirect()->back()->with('success', 'Pasta de documentos criada com sucesso.');
        } catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao criar a pasta de documentos: ' . $e->getMessage());
        }
        //
    }

    public function show($associado_id, $pasta_id)
    {
        $user = Auth::user();
        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $associado = Associado::findOrFail($associado_id);
        $pasta = $associado->pastaDocumentos()->with('files')->findOrFail($pasta_id);

        $arquivos = $pasta->files;

        $search = request('search');

        $documentos = $pasta->files()
            ->when($search, function ($query, $search) {
                $query->where('tipo_documento', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('observacao', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('associado.pastas.show', compact('pasta', 'associado', 'documentos', 'search', 'arquivos'));
    }
}
