<?php

declare(strict_types=1);

Broadcast::channel('adminarea-contacts-index', function ($user) {
    return $user->can('list', app('rinvex.contacts.contact'));
}, ['guards' => ['admin']]);
