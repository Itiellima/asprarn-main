<?php

namespace App\Console\Commands;

use App\Models\File;
use App\Models\PictureProfile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class LimparArquivosOrfaos extends Command
{
    protected $signature = 'arquivos:limpar-orfaos {--simular : Só lista o que seria removido, sem apagar nada}';

    protected $description = 'Remove do banco os registros de arquivos (documentos, fotos, imagens) que não existem mais no armazenamento';

    public function handle(): int
    {
        $simular = (bool) $this->option('simular');

        if ($simular) {
            $this->warn('Modo simulação: nada será apagado.');
        }

        $removidos = 0;

        File::query()->orderBy('id')->each(function (File $file) use ($simular, &$removidos) {
            if ($this->existe($file->disco(), $file->path)) {
                return;
            }

            $this->line("files #{$file->id} ({$file->disco()}) {$file->path}");
            $removidos++;

            if (!$simular) {
                // Sem eventos: o arquivo já não existe, não há o que apagar no armazenamento
                $file->deleteQuietly();
            }
        });

        PictureProfile::query()->orderBy('id')->each(function (PictureProfile $foto) use ($simular, &$removidos) {
            if ($this->existe('midia', $foto->path)) {
                return;
            }

            $this->line("picture_profiles #{$foto->id} (associado {$foto->associado_id}) {$foto->path}");
            $removidos++;

            if (!$simular) {
                $foto->delete();
            }
        });

        $this->info($simular
            ? "{$removidos} registro(s) seriam removidos."
            : "{$removidos} registro(s) removidos.");

        return self::SUCCESS;
    }

    private function existe(string $disco, ?string $path): bool
    {
        return $path && Storage::disk($disco)->exists($path);
    }
}
