<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cria roles, se não existirem
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'moderador']);
        Role::firstOrCreate(['name' => 'associado']);
        Role::firstOrCreate(['name' => 'user']);

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
