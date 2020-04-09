<?php

declare(strict_types=1);

namespace Cortex\Contacts\Console\Commands;

use Rinvex\Contacts\Console\Commands\PublishCommand as BasePublishCommand;

class PublishCommand extends BasePublishCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:publish:contacts {--f|force : Overwrite any existing files.} {--r|resource=* : Specify which resources to publish.}';

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
    public function handle(): void
    {
        parent::handle();

        collect($this->option('resource') ?: ['config', 'lang', 'views', 'migrations'])->each(function ($resource) {
            $this->call('vendor:publish', ['--tag' => "cortex/contacts::{$resource}", '--force' => $this->option('force')]);
        });

        $this->line('');
    }
}
