<?php

namespace App\Http\Controllers\Associado;

use App\Http\Controllers\Controller;
use App\Models\Associado;
use App\Models\PictureProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

/** Foto de perfil: o próprio associado ou admin/moderador (AssociadoPolicy::alterarFoto) */
class FotoPerfilController extends Controller
{
    public function store(Request $request, $associadoId)
    {
        $associado = Associado::findOrFail($associadoId);
        Gate::authorize('alterarFoto', $associado);

        $request->validate([
            'picture_profile' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ], [
            'picture_profile.required' => 'Selecione uma foto.',
            'picture_profile.uploaded' => 'Não foi possível enviar a foto. Tente uma imagem menor.',
            'picture_profile.image' => 'O arquivo deve ser uma imagem.',
            'picture_profile.mimes' => 'A foto deve ser JPG, PNG ou WEBP.',
            'picture_profile.max' => 'A foto não pode passar de 10MB.',
        ]);

        DB::beginTransaction();

        $newPath = null;

        try {
            $newPath = $request->file('picture_profile')->store('picture_profiles', 'midia');

            $oldPicture = PictureProfile::where('associado_id', $associado->id)->first();

            PictureProfile::updateOrCreate(
                ['associado_id' => $associado->id],
                ['path' => $newPath]
            );

            // Apaga a foto antiga só se for outro arquivo
            if ($oldPicture && $oldPicture->path !== $newPath && Storage::disk('midia')->exists($oldPicture->path)) {
                Storage::disk('midia')->delete($oldPicture->path);
            }

            DB::commit();

            return back()->with('msg', 'Foto de perfil atualizada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Evita arquivo órfão no bucket
            if ($newPath && Storage::disk('midia')->exists($newPath)) {
                Storage::disk('midia')->delete($newPath);
            }

            return back()->with('error', 'Erro ao atualizar foto.');
        }
    }

    public function destroy($associadoId)
    {
        $associado = Associado::findOrFail($associadoId);
        Gate::authorize('alterarFoto', $associado);

        $picture = PictureProfile::where('associado_id', $associado->id)->first();

        DB::beginTransaction();
        try {
            if ($picture) {
                if (Storage::disk('midia')->exists($picture->path)) {
                    Storage::disk('midia')->delete($picture->path);
                }

                $picture->delete();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao deletar foto.');
        }

        return back()->with('msg', 'Foto de perfil deletada com sucesso!');
    }
}
