<?php

declare(strict_types=1);

namespace Cortex\Contacts\Providers;

use Illuminate\Routing\Router;
use Cortex\Contacts\Models\Contact;
use Illuminate\Support\ServiceProvider;
use Rinvex\Support\Traits\ConsoleTools;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Relations\Relation;

class ContactsServiceProvider extends ServiceProvider
{
    use ConsoleTools;

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
