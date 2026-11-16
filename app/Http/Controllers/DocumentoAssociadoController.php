<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\PastaDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Arquivos dentro das pastas de documentos do associado.
 * Só a diretoria acessa: grupo de rotas role:admin|moderador (routes/web/admin.php).
 */
class DocumentoAssociadoController extends Controller
{
    // Enviar documento para a pasta
    public function store(Request $request, $pastaId)
    {
        $request->validate([
            // 10 MB: o mesmo limite da foto de perfil (docker/php.ini aceita até 10M por arquivo)
            'arquivo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'observacao' => 'nullable|string|max:1000',
        ], [
            'arquivo.required' => 'Selecione um arquivo.',
            'arquivo.mimes' => 'Envie um arquivo PDF, JPG ou PNG.',
            'arquivo.max' => 'O arquivo não pode passar de 10 MB.',
            'arquivo.uploaded' => 'Não foi possível enviar o arquivo. Tente um arquivo menor.',
        ]);

        $pasta = PastaDocumento::findOrFail($pastaId);

        $path = null;
        $disco = File::discoPara(PastaDocumento::class);

        try {
            DB::beginTransaction();

            $arquivo = $request->file('arquivo');

            // Salva o arquivo no bucket privado de documentos
            $path = $arquivo->store("documentos/{$pasta->associado_id}/{$pasta->id}", $disco);

            // tipo_documento guarda o nome original do arquivo (usado no download)
            $pasta->files()->create([
                'tipo_documento' => $arquivo->getClientOriginalName(),
                'path' => $path,
                'status' => 'pendente',
                'observacao' => $request->observacao,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Documento enviado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Evita arquivo órfão no bucket se o registro não foi salvo
            if ($path) {
                try {
                    Storage::disk($disco)->delete($path);
                } catch (\Exception $erroAoLimpar) {
                    Log::warning('Não foi possível remover o documento órfão ' . $path . ': ' . $erroAoLimpar->getMessage());
                }
            }

            report($e); // detalhe técnico vai para o log, não para a tela
            return redirect()->back()->with('error', 'Ocorreu um erro ao enviar o arquivo. Tente novamente.');
        }
    }

    // Exibir documento
    public function show($pastaId, $fileId)
    {
        // Verifica se o arquivo pertence à pasta
        $file = File::where('id', $fileId)
            ->where('fileable_type', PastaDocumento::class)
            ->where('fileable_id', $pastaId)
            ->firstOrFail();

        $disco = Storage::disk($file->disco());

        if (!$file->path || !$disco->exists($file->path)) {
            abort(404, 'Arquivo não encontrado.');
        }

        // O arquivo é lido do bucket e entregue pelo Laravel (o bucket nunca fica público)
        return $disco->response($file->path, $file->tipo_documento ?: basename($file->path), [
            'Cache-Control' => 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    // Excluir documento
    public function destroy($pastaId, $fileId)
    {
        $file = File::where('fileable_type', PastaDocumento::class)
            ->where('fileable_id', $pastaId)
            ->findOrFail($fileId);

        // Deleta o registro (o model File remove o arquivo do armazenamento)
        $file->delete();

        return redirect()->back()->with('success', 'Documento excluído com sucesso!');
    }

    // Atualizar status/observação
    public function update(Request $request, $pastaId, $fileId)
    {
        $request->validate([
            'status' => 'required|in:pendente,recebido,rejeitado',
            'observacao' => 'nullable|string|max:1000',
        ]);

        $file = File::where('fileable_type', PastaDocumento::class)
            ->where('fileable_id', $pastaId)
            ->findOrFail($fileId);

        $file->update($request->only('status', 'observacao'));

        return redirect()->back()->with('success', 'Documento atualizado com sucesso!');
    }
}
