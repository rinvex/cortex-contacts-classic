<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.crm'), 50, 'fa fa-briefcase', [], function (MenuItem $dropdown) {
        $dropdown->route(['adminarea.contacts.index'], trans('cortex/contacts::common.contacts'), 10, 'fa fa-id-card-o')->ifCan('list-contacts')->activateOnRoute('adminarea.contacts');
    });
});

Menu::register('managerarea.sidebar', function (MenuGenerator $menu) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.crm'), 50, 'fa fa-briefcase', [], function (MenuItem $dropdown) {
        $dropdown->route(['managerarea.contacts.index'], trans('cortex/contacts::common.contacts'), 10, 'fa fa-id-card-o')->ifCan('list-contacts')->activateOnRoute('managerarea.contacts');
    });
});
