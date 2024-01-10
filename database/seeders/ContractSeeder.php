<?php

namespace Database\Seeders;

use App\Models\Contract;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contracts = [
            [
                'customer_id' => 1,
                'product_id' => 7,
                'started_at' => '2023-12-10',
                'expire_day' => 10,
                'total_installments' => 1,
                'domain' => 'lohl.com.br',
            ],
            [
                'customer_id' => 1,
                'product_id' => 1,
                'started_at' => '2023-12-10',
                'expire_day' => 10,
                'total_installments' => 1,
                'domain' => 'brunoh.com.br',
            ],
        ];

        foreach ($contracts as $newContract)
        {
            $contract = Contract::where('customer_id', $newContract['customer_id'])
                ->where('product_id', $newContract['product_id'])
                ->where('domain', $newContract['domain'])
                ->first();

            if (!$contract)
            {
                $this->command->info('  creating contract: ' . $newContract['customer_id'] . '|' . $newContract['product_id'] . '|' . $newContract['domain']);

                Contract::create($newContract);
            }
        }
    }
}
