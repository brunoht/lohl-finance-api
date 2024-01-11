<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Usuario de Teste Primário',
                'email' => 'teste@lohl.com.br',
                'cpf' => '95626994041',
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'Usuario de Teste Secundário',
                'email' => 'teste2@lohl.com.br',
                'cpf' => '21880812002',
                'password' => Hash::make('123'),
            ],
        ];

        foreach ($users as $newUser)
        {
            $client = User::where('cpf', $newUser['cpf'])->first();

            if (!$client)
            {
                $this->command->info('  creating user: ' . $newUser['name']);

                User::create($newUser);
            }
        }
    }
}
