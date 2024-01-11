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
    protected $signature = 'app:refresh-page';

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
        event(new \App\Events\RefreshPage('hello world'));
    }
}
