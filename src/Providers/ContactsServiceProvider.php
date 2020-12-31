<?php

declare(strict_types=1);

namespace Cortex\Contacts\Providers;

use Illuminate\Routing\Router;
use Cortex\Contacts\Models\Contact;
use Illuminate\Support\ServiceProvider;
use Rinvex\Support\Traits\ConsoleTools;
use Illuminate\Contracts\Events\Dispatcher;
use Cortex\Contacts\Console\Commands\SeedCommand;
use Cortex\Contacts\Console\Commands\UnloadCommand;
use Cortex\Contacts\Console\Commands\InstallCommand;
use Cortex\Contacts\Console\Commands\MigrateCommand;
use Cortex\Contacts\Console\Commands\PublishCommand;
use Illuminate\Database\Eloquent\Relations\Relation;
use Cortex\Contacts\Console\Commands\RollbackCommand;
use Cortex\Contacts\Console\Commands\ActivateCommand;
use Cortex\Contacts\Console\Commands\AutoloadCommand;
use Cortex\Contacts\Console\Commands\DeactivateCommand;

class ContactsServiceProvider extends ServiceProvider
{
    use ConsoleTools;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        ActivateCommand::class => 'command.cortex.contacts.activate',
        DeactivateCommand::class => 'command.cortex.contacts.deactivate',
        AutoloadCommand::class => 'command.cortex.contacts.autoload',
        UnloadCommand::class => 'command.cortex.contacts.unload',

        SeedCommand::class => 'command.cortex.contacts.seed',
        InstallCommand::class => 'command.cortex.contacts.install',
        MigrateCommand::class => 'command.cortex.contacts.migrate',
        PublishCommand::class => 'command.cortex.contacts.publish',
        RollbackCommand::class => 'command.cortex.contacts.rollback',
    ];

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register(): void
    {
        // Bind eloquent models to IoC container
        $this->app['config']['rinvex.contacts.models.contact'] === Contact::class
        || $this->app->alias('rinvex.contacts.contact', Contact::class);

        // Register console commands
        $this->registerCommands($this->commands);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router, Dispatcher $dispatcher): void
    {
        // Bind route models and constrains
        $router->pattern('contact', '[a-zA-Z0-9-_]+');
        $router->model('contact', config('rinvex.contacts.models.contact'));

        // Map relations
        Relation::morphMap([
            'contact' => config('rinvex.contacts.models.contact'),
        ]);
    }
}
