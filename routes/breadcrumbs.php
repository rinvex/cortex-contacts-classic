<?php

declare(strict_types=1);

use Rinvex\Contacts\Contracts\ContactContract;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('adminarea.contacts.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.adminarea'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/contacts::common.contacts'), route('adminarea.contacts.index'));
});

Breadcrumbs::register('adminarea.contacts.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.contacts.index');
    $breadcrumbs->push(trans('cortex/contacts::common.create_contact'), route('adminarea.contacts.create'));
});

Breadcrumbs::register('adminarea.contacts.edit', function (BreadcrumbsGenerator $breadcrumbs, ContactContract $contact) {
    $breadcrumbs->parent('adminarea.contacts.index');
    $breadcrumbs->push($contact->name, route('adminarea.contacts.edit', ['contact' => $contact]));
});

Breadcrumbs::register('adminarea.contacts.logs', function (BreadcrumbsGenerator $breadcrumbs, ContactContract $contact) {
    $breadcrumbs->parent('adminarea.contacts.index');
    $breadcrumbs->push($contact->name, route('adminarea.contacts.edit', ['contact' => $contact]));
    $breadcrumbs->push(trans('cortex/contacts::common.logs'), route('adminarea.contacts.logs', ['contact' => $contact]));
});
