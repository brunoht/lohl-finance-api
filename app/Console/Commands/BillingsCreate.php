<?php

namespace App\Console\Commands;

use App\Models\Billing;
use App\Queries\ActiveContracts;
use App\Queries\CreateBilling;
use App\Queries\ProductById;
use Illuminate\Console\Command;

class BillingsCreate extends Command
{
    private $activeContracts;
    private $productById;
    private $createBilling;

    public function __construct(
        ActiveContracts $activeContracts,
        ProductById $productById,
        CreateBilling $createBilling
    ) {
        parent::__construct();

        $this->activeContracts = $activeContracts;
        $this->productById = $productById;
        $this->createBilling = $createBilling;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:billings-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create billings based on contracts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        system('clear'); // clear the console

        // get all active contracts
        $contracts = $this->activeContracts->toArray();

        if (count($contracts) === 0) {
            $this->info('No contracts found');
            return 0;
        }

        $billings = [];

        // loop through contracts
        foreach ($contracts as $contract)
        {
            // check if the contract already has a billing
            if (Billing::where('contract_id', $contract['id'])->exists()) continue;

            // get product data
            $product = $this->productById
                ->param('id', $contract['product_id'])
                ->first()
                ->toArray();

            $billing = $this->createBilling
                ->params(['product' => $product, 'contract' => $contract])
                ->first()
                ->toArray();

            $billings[] = [
                'uuid' => $billing['uuid'],
                'customer' => $billing['contract']['customer']['user']['name'],
                'domain' => $billing['contract']['domain'],
                'product' => $billing['contract']['product']['title'],
                'price' => $billing['contract']['product']['price'],
                'expire_at' => $billing['expire_at'],
            ];
        }

        if (count($billings) === 0)
            $this->info('Billings already created for this month');
        else
            $this->table(
                ['UUID', 'Cliente', 'Domínio', 'Produto', 'Valor', 'Vencimento'],
                $billings
            );

        return 0;
    }
}
