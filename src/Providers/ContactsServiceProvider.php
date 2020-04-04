<?php

declare(strict_types=1);

namespace Cortex\Contacts\Providers;

use Illuminate\Routing\Router;
use Cortex\Contacts\Models\Contact;
use Illuminate\Support\ServiceProvider;
use Rinvex\Support\Traits\ConsoleTools;
use Illuminate\Contracts\Events\Dispatcher;
use Cortex\Contacts\Console\Commands\SeedCommand;
use Cortex\Contacts\Console\Commands\InstallCommand;
use Cortex\Contacts\Console\Commands\MigrateCommand;
use Cortex\Contacts\Console\Commands\PublishCommand;
use Illuminate\Database\Eloquent\Relations\Relation;
use Cortex\Contacts\Console\Commands\RollbackCommand;

class ContactsServiceProvider extends ServiceProvider
{
    use ConsoleTools;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
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
        // Merge config
        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/config.php'), 'cortex.contacts');

        // Bind eloquent models to IoC container
        $this->app['config']['rinvex.contacts.models.contact'] === Contact::class
        || $this->app->alias('rinvex.contacts.contact', Contact::class);

        // Register console commands
        ! $this->app->runningInConsole() || $this->registerCommands();
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

        // Load resources
        $this->loadRoutesFrom(__DIR__.'/../../routes/web/adminarea.php');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web/managerarea.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/contacts');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'cortex/contacts');
        ! $this->autoloadMigrations('cortex/contacts') || $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->app->runningInConsole() || $dispatcher->listen('accessarea.ready', function ($accessarea) {
            ! file_exists($menus = __DIR__."/../../routes/menus/{$accessarea}.php") || require $menus;
            ! file_exists($breadcrumbs = __DIR__."/../../routes/breadcrumbs/{$accessarea}.php") || require $breadcrumbs;
        });

        // Publish Resources
        $this->publishesLang('cortex/contacts', true);
        $this->publishesViews('cortex/contacts', true);
        $this->publishesMigrations('cortex/contacts', true);
    }
}
