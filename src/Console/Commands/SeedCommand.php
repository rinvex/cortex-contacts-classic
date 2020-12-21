<?php

declare(strict_types=1);

namespace Cortex\Contacts\Console\Commands;

use Illuminate\Console\Command;
use Cortex\Contacts\Database\Seeders\CortexContactsSeeder;

class SeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:seed:contacts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed Cortex Contacts Data.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->alert($this->description);

        $this->call('db:seed', ['--class' => CortexContactsSeeder::class]);

        $this->line('');
    }
}
