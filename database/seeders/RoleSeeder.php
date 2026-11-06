<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lista única dos perfis: o RoleAndAdminSeeder e os testes usam este seeder
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'moderador']);
        Role::firstOrCreate(['name' => 'associado']);
        Role::firstOrCreate(['name' => 'user']);
        Role::firstOrCreate(['name' => 'financeiro']);
    }
}
