<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class RoleAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cria roles, se não existirem
        $this->call(RoleSeeder::class);

        // Cria usuário admin (ou pega se já existir)
        $admin = User::firstOrCreate(
            ['email' => 'admin@exemplo.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('senha123'),
            ]
        );

        // Atribui role admin ao usuário
        $admin->syncRoles('admin', 'moderador', 'associado', 'user');
    }
}
