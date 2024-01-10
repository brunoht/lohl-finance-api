<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Comprador Primário de Teste',
                'cpf' => '95626994041',
                'email' => 'teste@lohl.com.br',
            ],
            [
                'name' => 'Comprador de Teste Secundário',
                'cpf' => '21880812002',
                'email' => 'teste2@lohl.com.br',
            ],
        ];

        foreach ($customers as $newCustormer)
        {
            $client = Customer::where('cpf', $newCustormer['cpf'])->first();

            if (!$client)
            {
                $this->command->info('  creating client: ' . $newCustormer['name']);

                Customer::create($newCustormer);
            }
        }

    }
}
