<?php

namespace App\Console\Commands;

use App\Models\Billing;
use Illuminate\Console\Command;

class BillingsList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all billings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // clear the console
        system('clear');

        $billings = Billing::with([
                'items',
                'contract',
                'contract.product',
                'contract.customer',
                'contract.customer.user',
                'payment'
            ])
            ->get()->toArray();

        if (count($billings) === 0) {
            $this->info('No billings found');
            return 0;
        }

        $filteredBillings = [];

        foreach($billings as $billing) {
            $filteredBillings[] = [
                'uuid' => $billing['uuid'],
                'customer' => $billing['contract']['customer']['user']['name'],
                'domain' => $billing['contract']['domain'],
                'product' => $billing['contract']['product']['title'],
                'price' => $billing['contract']['product']['price'],
                'expire_at' => $billing['expire_at'],
                'paid_at' => $billing['payment']['date_approved'] ?? null,
            ];
        }

        $this->table(
            ['UUID', 'Cliente', 'Domínio', 'Produto', 'Valor', 'Vencimento', 'Pagamento'],
            $filteredBillings
        );

        return 0;
    }
}
