<?php

declare(strict_types=1);

namespace Cortex\Contacts\Providers;

use Illuminate\Routing\Router;
use Cortex\Contacts\Models\Contact;
use Illuminate\Support\ServiceProvider;
use Cortex\Contacts\Console\Commands\SeedCommand;
use Cortex\Contacts\Console\Commands\InstallCommand;
use Cortex\Contacts\Console\Commands\MigrateCommand;
use Cortex\Contacts\Console\Commands\PublishCommand;
use Illuminate\Database\Eloquent\Relations\Relation;
use Cortex\Contacts\Console\Commands\RollbackCommand;

class ContactsServiceProvider extends ServiceProvider
{
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
    public function boot(Router $router): void
    {
        // Bind route models and constrains
        $router->pattern('contact', '[0-9]+');
        $router->model('contact', config('rinvex.contacts.models.contact'));

        // Map relations
        Relation::morphMap([
            'contact' => config('rinvex.contacts.models.contact'),
        ]);

        // Load resources
        require __DIR__.'/../../routes/breadcrumbs.php';
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/contacts');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'cortex/contacts');
        ! $this->app->runningInConsole() || $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->app->runningInConsole() || $this->app->afterResolving('blade.compiler', function () {
            require __DIR__.'/../../routes/menus.php';
        });

        // Publish Resources
        ! $this->app->runningInConsole() || $this->publishResources();
    }

    /**
     * Publish resources.
     *
     * @return void
     */
    protected function publishResources(): void
    {
        $this->publishes([realpath(__DIR__.'/../../database/migrations') => database_path('migrations')], 'cortex-contacts-migrations');
        $this->publishes([realpath(__DIR__.'/../../resources/lang') => resource_path('lang/vendor/cortex/contacts')], 'cortex-contacts-lang');
        $this->publishes([realpath(__DIR__.'/../../resources/views') => resource_path('views/vendor/cortex/contacts')], 'cortex-contacts-views');
    }

    /**
     * Register console commands.
     *
     * @return void
     */
    protected function registerCommands(): void
    {
        // Register artisan commands
        foreach ($this->commands as $key => $value) {
            $this->app->singleton($value, $key);
        }

        $this->commands(array_values($this->commands));
    }
}
