<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;

class MakeUUID extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:uuid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new UUID string';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $uuid = Uuid::uuid4();
        $this->info($uuid->toString());
        return 0;
    }
}
