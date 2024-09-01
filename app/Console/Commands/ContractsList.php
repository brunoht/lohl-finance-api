<?php

namespace App\Console\Commands;

use App\Models\Contract;
use Illuminate\Console\Command;

class ContractsList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contract:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all contracts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // clear the console
        system('clear');

        $contracts = Contract::with('customer', 'customer.user', 'product')->get();

        if ($contracts->count() === 0) {
            $this->info('No contracts found');
            return 0;
        }

        $filteredContracts = [];

        foreach($contracts as $contract) {
            $filteredContracts[] = [
                'ID' => $contract->id,
                'Domain' => $contract->domain,
                'Client' => $contract->customer->user->name,
                'Product' => $contract->product->title,
                'Value' => $contract->product->price,
                'Start' => $contract->started_at,
                'End' => $contract->finished_at,
            ];
        }

        $this->table(
            ['ID', 'Domain', 'Client', 'Product', 'Value', 'Start', 'End'],
            $filteredContracts
        );

        return 0;
    }
}
