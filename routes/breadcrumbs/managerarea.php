<?php

declare(strict_types=1);

use Cortex\Contacts\Models\Contact;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('managerarea.contacts.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('rinvex.tenants.active')->name, route('managerarea.home'));
    $breadcrumbs->push(trans('cortex/contacts::common.contacts'), route('managerarea.contacts.index'));
});

Breadcrumbs::register('managerarea.contacts.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.contacts.index');
    $breadcrumbs->push(trans('cortex/contacts::common.import'), route('managerarea.contacts.import'));
});

Breadcrumbs::register('managerarea.contacts.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.contacts.index');
    $breadcrumbs->push(trans('cortex/contacts::common.import'), route('managerarea.contacts.import'));
    $breadcrumbs->push(trans('cortex/contacts::common.logs'), route('managerarea.contacts.import.logs'));
});

Breadcrumbs::register('managerarea.contacts.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.contacts.index');
    $breadcrumbs->push(trans('cortex/contacts::common.create_contact'), route('managerarea.contacts.create'));
});

Breadcrumbs::register('managerarea.contacts.edit', function (BreadcrumbsGenerator $breadcrumbs, Contact $contact) {
    $breadcrumbs->parent('managerarea.contacts.index');
    $breadcrumbs->push($contact->full_name, route('managerarea.contacts.edit', ['contact' => $contact]));
});

Breadcrumbs::register('managerarea.contacts.logs', function (BreadcrumbsGenerator $breadcrumbs, Contact $contact) {
    $breadcrumbs->parent('managerarea.contacts.index');
    $breadcrumbs->push($contact->full_name, route('managerarea.contacts.edit', ['contact' => $contact]));
    $breadcrumbs->push(trans('cortex/contacts::common.logs'), route('managerarea.contacts.logs', ['contact' => $contact]));
});
