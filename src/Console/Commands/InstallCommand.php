<?php

declare(strict_types=1);

namespace Cortex\Contacts\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:install:contacts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Cortex Contacts Module.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->warn($this->description);

        $this->call('cortex:migrate:contacts');
        $this->call('cortex:seed:contacts');
        $this->call('cortex:publish:contacts');
    }
}
