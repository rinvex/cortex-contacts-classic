<?php

declare(strict_types=1);

use Cortex\Contacts\Models\Contact;
use Diglactic\Breadcrumbs\Generator;
use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::register('managerarea.cortex.contacts.contacts.index', function (Generator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.app('request.tenant')->name, route('managerarea.home'));
    $breadcrumbs->push(trans('cortex/contacts::common.contacts'), route('managerarea.cortex.contacts.contacts.index'));
});

Breadcrumbs::register('managerarea.cortex.contacts.contacts.import', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.cortex.contacts.contacts.index');
    $breadcrumbs->push(trans('cortex/contacts::common.import'), route('managerarea.cortex.contacts.contacts.import'));
});

Breadcrumbs::register('managerarea.cortex.contacts.contacts.import.logs', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.cortex.contacts.contacts.index');
    $breadcrumbs->push(trans('cortex/contacts::common.import'), route('managerarea.cortex.contacts.contacts.import'));
    $breadcrumbs->push(trans('cortex/contacts::common.logs'), route('managerarea.cortex.contacts.contacts.import.logs'));
});

Breadcrumbs::register('managerarea.cortex.contacts.contacts.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.cortex.contacts.contacts.index');
    $breadcrumbs->push(trans('cortex/contacts::common.create_contact'), route('managerarea.cortex.contacts.contacts.create'));
});

Breadcrumbs::register('managerarea.cortex.contacts.contacts.edit', function (Generator $breadcrumbs, Contact $contact) {
    $breadcrumbs->parent('managerarea.cortex.contacts.contacts.index');
    $breadcrumbs->push(strip_tags($contact->full_name), route('managerarea.cortex.contacts.contacts.edit', ['contact' => $contact]));
});

Breadcrumbs::register('managerarea.cortex.contacts.contacts.logs', function (Generator $breadcrumbs, Contact $contact) {
    $breadcrumbs->parent('managerarea.cortex.contacts.contacts.index');
    $breadcrumbs->push(strip_tags($contact->full_name), route('managerarea.cortex.contacts.contacts.edit', ['contact' => $contact]));
    $breadcrumbs->push(trans('cortex/contacts::common.logs'), route('managerarea.cortex.contacts.contacts.logs', ['contact' => $contact]));
});
