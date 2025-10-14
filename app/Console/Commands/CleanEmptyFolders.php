<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;

class CleanEmptyFolders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-empty-folders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Verificando pastas vazias em storage/app/public/documentos...');

        $disk = Storage::disk('public');
        $root = 'documentos';

        $this->deleteEmptyDirs($disk, $root);

        $this->info('Limpeza concluída!');
    }

    private function deleteEmptyDirs($disk, $path)
    {
        foreach ($disk->directories($path) as $dir) {
            $this->deleteEmptyDirs($disk, $dir); // recursivo

            // Se o diretório estiver vazio após as verificações, apaga
            if (
                empty($disk->files($dir)) &&
                empty($disk->directories($dir))
            ) {
                $disk->deleteDirectory($dir);
                $this->line("🗑️  Pasta removida: {$dir}");
            }
        }
    }
}
