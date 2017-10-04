<?php

declare(strict_types=1);

namespace Cortex\Contacts\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Rinvex\Contacts\Contracts\ContactContract;
use Cortex\Contacts\Console\Commands\SeedCommand;
use Cortex\Contacts\Console\Commands\InstallCommand;
use Cortex\Contacts\Console\Commands\MigrateCommand;
use Cortex\Contacts\Console\Commands\PublishCommand;
use Illuminate\Database\Eloquent\Relations\Relation;

class ContactsServiceProvider extends ServiceProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        MigrateCommand::class => 'command.cortex.contacts.migrate',
        PublishCommand::class => 'command.cortex.contacts.publish',
        InstallCommand::class => 'command.cortex.contacts.install',
        SeedCommand::class => 'command.cortex.contacts.seed',
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
    public function register()
    {
        // Register console commands
        ! $this->app->runningInConsole() || $this->registerCommands();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // Bind route models and constrains
        $router->pattern('contact', '[a-z0-9-]+');
        $router->model('contact', ContactContract::class);

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
        $this->app->afterResolving('blade.compiler', function () {
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
    protected function publishResources()
    {
        $this->publishes([realpath(__DIR__.'/../../resources/lang') => resource_path('lang/vendor/cortex/contacts')], 'cortex-contacts-lang');
        $this->publishes([realpath(__DIR__.'/../../resources/views') => resource_path('views/vendor/cortex/contacts')], 'cortex-contacts-views');
    }

    /**
     * Register console commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        // Register artisan commands
        foreach ($this->commands as $key => $value) {
            $this->app->singleton($value, function ($app) use ($key) {
                return new $key();
            });
        }

        $this->commands(array_values($this->commands));
    }
}
