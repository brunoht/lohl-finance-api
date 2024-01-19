<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RefreshPage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh {billing_uuid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $billingUuid = $this->argument('billing_uuid');

        event(new \App\Events\RefreshPage($billingUuid));

        $this->info('Sent refresh event to billing ' . $billingUuid);

        return 0;
    }
}
