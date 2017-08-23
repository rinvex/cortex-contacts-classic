<?php

declare(strict_types=1);

use Rinvex\Contacts\Contracts\ContactContract;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('backend.contacts.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.backend'), route('backend.home'));
    $breadcrumbs->push(trans('cortex/contacts::common.contacts'), route('backend.contacts.index'));
});

Breadcrumbs::register('backend.contacts.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('backend.contacts.index');
    $breadcrumbs->push(trans('cortex/contacts::common.create_contact'), route('backend.contacts.create'));
});

Breadcrumbs::register('backend.contacts.edit', function (BreadcrumbsGenerator $breadcrumbs, ContactContract $contact) {
    $breadcrumbs->parent('backend.contacts.index');
    $breadcrumbs->push($contact->name, route('backend.contacts.edit', ['contact' => $contact]));
});

Breadcrumbs::register('backend.contacts.logs', function (BreadcrumbsGenerator $breadcrumbs, ContactContract $contact) {
    $breadcrumbs->parent('backend.contacts.index');
    $breadcrumbs->push($contact->name, route('backend.contacts.edit', ['contact' => $contact]));
    $breadcrumbs->push(trans('cortex/contacts::common.logs'), route('backend.contacts.logs', ['contact' => $contact]));
});
