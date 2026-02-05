<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Associado;
use App\Models\File; // novo model polimórfico
use App\Models\PastaDocumento;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DocumentoAssociadoController extends Controller
{

    // public function indexDocumento($id)
    // {

    //     $user = Auth::user();

    //     if (!$user || !$user->hasAnyRole(['admin', 'moderador'])) {
    //         return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
    //     }

    //     $pasta = PastaDocumento::with([
    //         'files',
    //         'associado'
    //     ])->findOrFail($id);

    //     $search = request('search');

    //     $documentos = $pasta->files()
    //         ->when($search, function ($query, $search) {
    //             $query->where('tipo_documento', 'like', "%{$search}%")
    //                 ->orWhere('status', 'like', "%{$search}%")
    //                 ->orWhere('observacao', 'like', "%{$search}%");
    //         })
    //         ->paginate(10);

    //     return view('associado.documentos.index', compact('pasta', 'documentos', 'search'));
    // }

    // Criar documento na pasta
    public function store(Request $request, $pastaId)
    {
        // verifica se o usuário está autenticado e tem a função necessária
        $user = Auth::user();
        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        // Validação dos dados do formulário
        $request->validate([
            'tipo_documento' => 'string|max:50',
            'arquivo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'observacao' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Confirma se a pasta existe
            $pasta = PastaDocumento::findOrFail($pastaId);

            // Obtém o ID do associado da pasta
            $associadoId = $pasta->associado_id;

            // Obtém o arquivo enviado
            $arquivo = $request->file('arquivo');

            // Obtém o nome original do arquivo
            $nomeOriginal = $arquivo->getClientOriginalName();

            // Salva o arquivo e o caminho para armazenar o arquivo
            $path = $request->file('arquivo')->store("documentos/{$associadoId}/{$pastaId}", 'public');

            // Cria o registro do arquivo na tabela files
            $pasta->files()->create([
                'tipo_documento' => $nomeOriginal,
                'path' => $path,
                'status' => 'pendente',
                'observacao' => $request->observacao,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Documento enviado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao enviar documentos' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocorreu um erro ao enviar os arquivos, tente novamente');
        }
    }

    // Exibir documento
    public function show($pastaId, $fileId)
    {
        $user = Auth::user();
        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        // Verifica se o arquivo pertence à pasta
        $file = File::where('id', $fileId)
            ->where('fileable_type', PastaDocumento::class)
            ->where('fileable_id', $pastaId)
            ->firstOrFail();


        if ($file->path && Storage::disk('public')->exists($file->path)) {
            return response()->file(Storage::disk('public')->path($file->path));
        }

        abort(404, 'Arquivo não encontrado.');
    }

    // Excluir documento
    public function destroy($pastaId, $fileId)
    {
        $user = Auth::user();
        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        // Verifica se o arquivo pertence ao associado através da pasta
        $file = File::where('id', $fileId)
            ->where('fileable_type', PastaDocumento::class)
            ->where('fileable_id', $pastaId)
            ->findOrFail($fileId);

        // Deleta o arquivo do storage se existir
        if ($file->path && Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }

        // Deleta o registro do arquivo
        $file->delete();

        return redirect()->back()->with('success', 'Documento excluído com sucesso!');
    }









    // Atualizar status/observação
    public function update(Request $request, $pastaId, $fileId)
    {
        $user = Auth::user();

        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])) {
            return redirect()->route('index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $request->validate([
            'status' => 'required|in:pendente,recebido,rejeitado',
            'observacao' => 'nullable|string',
        ]);

        $file = File::where('fileable_type', PastaDocumento::class)
            ->where('fileable_id', $pastaId)
            ->findOrFail($fileId);

        $file->update($request->only('status', 'observacao'));

        return redirect()->back()->with('success', 'Documento atualizado com sucesso!');
    }
}
