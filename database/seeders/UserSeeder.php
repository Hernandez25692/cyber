<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@cybersandoval.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
                'rol' => 'admin'
            ]
        );

        // Cajero
        User::updateOrCreate(
            ['email' => 'cajero@cybersandoval.com'],
            [
                'name' => 'Mirna Perez',
                'password' => Hash::make('cajero123'),
                'rol' => 'cajero'
            ]
        );
    }
}
