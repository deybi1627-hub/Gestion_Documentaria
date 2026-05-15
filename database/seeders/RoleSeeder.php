<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Pedagógico',
            'email' => 'admin@pedagogico.edu.pe',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Secretario Pedagógico',
            'email' => 'secre@pedagogico.edu.pe',
            'password' => Hash::make('secre123'),
            'role' => 'secretario',
        ]);
    }
}