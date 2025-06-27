<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'tipo' => 'aluno',
            ]
        );

        \App\Models\User::firstOrCreate(
            ['email' => 'novo@exemplo.com'],
            [
                'name' => 'Novo Usuário',
                'password' => bcrypt('senha123'),
                'tipo' => 'aluno',
            ]
        );
    }
}
