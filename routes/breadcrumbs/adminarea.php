<?php

declare(strict_types=1);

use Cortex\Contacts\Models\Contact;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator;

Breadcrumbs::register('adminarea.cortex.contacts.contacts.index', function (Generator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/contacts::common.contacts'), route('adminarea.cortex.contacts.contacts.index'));
});

Breadcrumbs::register('adminarea.cortex.contacts.contacts.import', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.contacts.contacts.index');
    $breadcrumbs->push(trans('cortex/contacts::common.import'), route('adminarea.cortex.contacts.contacts.import'));
});

Breadcrumbs::register('adminarea.cortex.contacts.contacts.import.logs', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.contacts.contacts.index');
    $breadcrumbs->push(trans('cortex/contacts::common.import'), route('adminarea.cortex.contacts.contacts.import'));
    $breadcrumbs->push(trans('cortex/contacts::common.logs'), route('adminarea.cortex.contacts.contacts.import.logs'));
});

Breadcrumbs::register('adminarea.cortex.contacts.contacts.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.contacts.contacts.index');
    $breadcrumbs->push(trans('cortex/contacts::common.create_contact'), route('adminarea.cortex.contacts.contacts.create'));
});

Breadcrumbs::register('adminarea.cortex.contacts.contacts.edit', function (Generator $breadcrumbs, Contact $contact) {
    $breadcrumbs->parent('adminarea.cortex.contacts.contacts.index');
    $breadcrumbs->push(strip_tags($contact->full_name), route('adminarea.cortex.contacts.contacts.edit', ['contact' => $contact]));
});

Breadcrumbs::register('adminarea.cortex.contacts.contacts.logs', function (Generator $breadcrumbs, Contact $contact) {
    $breadcrumbs->parent('adminarea.cortex.contacts.contacts.index');
    $breadcrumbs->push(strip_tags($contact->full_name), route('adminarea.cortex.contacts.contacts.edit', ['contact' => $contact]));
    $breadcrumbs->push(trans('cortex/contacts::common.logs'), route('adminarea.cortex.contacts.contacts.logs', ['contact' => $contact]));
});
