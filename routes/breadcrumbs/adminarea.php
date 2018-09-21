<?php

declare(strict_types=1);

use Cortex\Contacts\Models\Contact;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('adminarea.contacts.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/contacts::common.contacts'), route('adminarea.contacts.index'));
});

Breadcrumbs::register('adminarea.contacts.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.contacts.index');
    $breadcrumbs->push(trans('cortex/contacts::common.import'), route('adminarea.contacts.import'));
});

Breadcrumbs::register('adminarea.contacts.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.contacts.index');
    $breadcrumbs->push(trans('cortex/contacts::common.import'), route('adminarea.contacts.import'));
    $breadcrumbs->push(trans('cortex/contacts::common.logs'), route('adminarea.contacts.import.logs'));
});

Breadcrumbs::register('adminarea.contacts.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.contacts.index');
    $breadcrumbs->push(trans('cortex/contacts::common.create_contact'), route('adminarea.contacts.create'));
});

Breadcrumbs::register('adminarea.contacts.edit', function (BreadcrumbsGenerator $breadcrumbs, Contact $contact) {
    $breadcrumbs->parent('adminarea.contacts.index');
    $breadcrumbs->push($contact->full_name, route('adminarea.contacts.edit', ['contact' => $contact]));
});

Breadcrumbs::register('adminarea.contacts.logs', function (BreadcrumbsGenerator $breadcrumbs, Contact $contact) {
    $breadcrumbs->parent('adminarea.contacts.index');
    $breadcrumbs->push($contact->full_name, route('adminarea.contacts.edit', ['contact' => $contact]));
    $breadcrumbs->push(trans('cortex/contacts::common.logs'), route('adminarea.contacts.logs', ['contact' => $contact]));
});
