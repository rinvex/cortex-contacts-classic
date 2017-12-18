<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Factories\MenuFactory;

Menu::modify('adminarea.sidebar', function(MenuFactory $menu) {
    $menu->findBy('title', trans('cortex/foundation::common.crm'), function (MenuItem $dropdown) {
        $dropdown->route(['adminarea.contacts.index'], trans('cortex/contacts::common.contacts'), 10, 'fa fa-id-card-o')->can('list-contacts');
    });
});

Menu::modify('managerarea.sidebar', function(MenuFactory $menu) {
    $menu->findBy('title', trans('cortex/foundation::common.crm'), function (MenuItem $dropdown) {
        $dropdown->route(['managerarea.contacts.index'], trans('cortex/contacts::common.contacts'), 10, 'fa fa-id-card-o')->can('list-contacts');
    });
});
