<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Cortex\Contacts\Models\Contact;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.crm'), 50, 'fa fa-briefcase', 'header', [], function (MenuItem $dropdown) {
        $dropdown->route(['adminarea.cortex.contacts.contacts.index'], trans('cortex/contacts::common.contacts'), 10, 'fa fa-id-card-o')->ifCan('list', app('rinvex.contacts.contact'))->activateOnRoute('adminarea.cortex.contacts.contacts');
    });
});

Menu::register('adminarea.cortex.contacts.contacts.tabs', function (MenuGenerator $menu, Contact $contact) {
    $menu->route(['adminarea.cortex.contacts.contacts.import'], trans('cortex/contacts::common.records'))->ifCan('import', $contact)->if(Route::is('adminarea.cortex.contacts.contacts.import*'));
    $menu->route(['adminarea.cortex.contacts.contacts.import.logs'], trans('cortex/contacts::common.logs'))->ifCan('import', $contact)->if(Route::is('adminarea.cortex.contacts.contacts.import*'));
    $menu->route(['adminarea.cortex.contacts.contacts.create'], trans('cortex/contacts::common.details'))->ifCan('create', $contact)->if(Route::is('adminarea.cortex.contacts.contacts.create'));
    $menu->route(['adminarea.cortex.contacts.contacts.edit', ['contact' => $contact]], trans('cortex/contacts::common.details'))->ifCan('update', $contact)->if($contact->exists);
    $menu->route(['adminarea.cortex.contacts.contacts.logs', ['contact' => $contact]], trans('cortex/contacts::common.logs'))->ifCan('audit', $contact)->if($contact->exists);
});
