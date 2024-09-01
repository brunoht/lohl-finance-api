<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AppClientsList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clients-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all clients';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // clear the console
        system('clear');
        
        $this->table(
            ['ID', 'Name', 'Email', 'Whatsapp'],
            \App\Models\User::all(['id', 'name', 'email', 'whatsapp'])->toArray()
        );

        return 0;
    }
}