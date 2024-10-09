<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Criar a função 'profissional' se não existir
        if (!Role::where('name', 'profissional')->exists()) {
            Role::create(['name' => 'profissional']);
        }

        // Criar a função 'admin' se não existir
        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
        }
        //Role::findByName('admin')->delete();

    }
}
