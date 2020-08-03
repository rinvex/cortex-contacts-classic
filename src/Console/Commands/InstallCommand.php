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
    protected $signature = 'cortex:install:contacts {--f|force : Force the operation to run when in production.} {--r|resource=* : Specify which resources to publish.}';

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
        $this->alert($this->description);

        $this->call('cortex:publish:contacts', ['--force' => $this->option('force'), '--resource' => $this->option('resource')]);
        $this->call('cortex:migrate:contacts', ['--force' => $this->option('force')]);
        $this->call('cortex:seed:contacts');

        $this->call('cortex:activate', ['--module' => 'cortex/contacts']);
    }
}
