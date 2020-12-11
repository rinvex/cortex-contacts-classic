<?php

declare(strict_types=1);

use Cortex\Contacts\Models\Contact;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('managerarea.cortex.contacts.contacts.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.app('request.tenant')->name, route('managerarea.home'));
    $breadcrumbs->push(trans('cortex/contacts::common.contacts'), route('managerarea.cortex.contacts.contacts.index'));
});

Breadcrumbs::register('managerarea.cortex.contacts.contacts.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.cortex.contacts.contacts.index');
    $breadcrumbs->push(trans('cortex/contacts::common.import'), route('managerarea.cortex.contacts.contacts.import'));
});

Breadcrumbs::register('managerarea.cortex.contacts.contacts.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.cortex.contacts.contacts.index');
    $breadcrumbs->push(trans('cortex/contacts::common.import'), route('managerarea.cortex.contacts.contacts.import'));
    $breadcrumbs->push(trans('cortex/contacts::common.logs'), route('managerarea.cortex.contacts.contacts.import.logs'));
});

Breadcrumbs::register('managerarea.cortex.contacts.contacts.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.cortex.contacts.contacts.index');
    $breadcrumbs->push(trans('cortex/contacts::common.create_contact'), route('managerarea.cortex.contacts.contacts.create'));
});

Breadcrumbs::register('managerarea.cortex.contacts.contacts.edit', function (BreadcrumbsGenerator $breadcrumbs, Contact $contact) {
    $breadcrumbs->parent('managerarea.cortex.contacts.contacts.index');
    $breadcrumbs->push(strip_tags($contact->full_name), route('managerarea.cortex.contacts.contacts.edit', ['contact' => $contact]));
});

Breadcrumbs::register('managerarea.cortex.contacts.contacts.logs', function (BreadcrumbsGenerator $breadcrumbs, Contact $contact) {
    $breadcrumbs->parent('managerarea.cortex.contacts.contacts.index');
    $breadcrumbs->push(strip_tags($contact->full_name), route('managerarea.cortex.contacts.contacts.edit', ['contact' => $contact]));
    $breadcrumbs->push(trans('cortex/contacts::common.logs'), route('managerarea.cortex.contacts.contacts.logs', ['contact' => $contact]));
});
