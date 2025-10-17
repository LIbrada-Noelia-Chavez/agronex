<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🧑‍💼 Administrador general
        User::updateOrCreate(
            ['email' => 'admin@finca.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // 👨‍🌾 Capataz de Cultivos
        User::updateOrCreate(
            ['email' => 'cultivo@finca.com'],
            [
                'name' => 'Capataz Cultivos',
                'password' => Hash::make('cultivo123'),
                'role' => 'capataz_cultivo',
            ]
        );

        // 🐄 Capataz de Ganado
        User::updateOrCreate(
            ['email' => 'ganado@finca.com'],
            [
                'name' => 'Capataz Ganado',
                'password' => Hash::make('ganado123'),
                'role' => 'capataz_ganado',
            ]
        );
    }
}
