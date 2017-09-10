<?php

declare(strict_types=1);

namespace Cortex\Contacts\Console\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:publish:contacts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Cortex Contacts Resources.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn('Publish cortex/contacts:');
        $this->call('vendor:publish', ['--tag' => 'rinvex-contacts-config']);
        $this->call('vendor:publish', ['--tag' => 'cortex-contacts-views']);
        $this->call('vendor:publish', ['--tag' => 'cortex-contacts-lang']);
    }
}
