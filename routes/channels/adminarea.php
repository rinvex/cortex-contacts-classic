<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Access\Authorizable;

Broadcast::channel('adminarea-contacts-index', function (Authorizable $user) {
    return $user->can('list', app('rinvex.contacts.contact'));
}, ['guards' => ['admin']]);
