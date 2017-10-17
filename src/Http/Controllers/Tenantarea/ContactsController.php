<?php

declare(strict_types=1);

namespace Cortex\Contacts\Http\Controllers\Tenantarea;

use Illuminate\Http\Request;
use Rinvex\Contacts\Contracts\ContactContract;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Contacts\DataTables\Tenantarea\ContactsDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Contacts\Http\Requests\Tenantarea\ContactFormRequest;

class ContactsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'contacts';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return app(ContactsDataTable::class)->with([
            'id' => 'cortex-contacts',
            'phrase' => trans('cortex/contacts::common.contacts'),
        ])->render('cortex/foundation::tenantarea.pages.datatable');
    }

    /**
     * Display a listing of the resource logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function logs(ContactContract $contact)
    {
        return app(LogsDataTable::class)->with([
            'tab' => 'logs',
            'type' => 'contacts',
            'resource' => $contact,
            'id' => 'cortex-contacts-logs',
            'phrase' => trans('cortex/contacts::common.contacts'),
        ])->render('cortex/foundation::tenantarea.pages.datatable-tab');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Contacts\Http\Requests\Tenantarea\ContactFormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ContactFormRequest $request)
    {
        return $this->process($request, app('rinvex.contacts.contact'));
    }

    /**
     * Update the given resource in storage.
     *
     * @param \Cortex\Contacts\Http\Requests\Tenantarea\ContactFormRequest $request
     * @param \Rinvex\Contacts\Contracts\ContactContract                   $contact
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ContactFormRequest $request, ContactContract $contact)
    {
        return $this->process($request, $contact);
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Rinvex\Contacts\Contracts\ContactContract $contact
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(ContactContract $contact)
    {
        $contact->delete();

        return intend([
            'url' => route('tenantarea.contacts.index'),
            'with' => ['warning' => trans('cortex/contacts::messages.contact.deleted', ['slug' => $contact->slug])],
        ]);
    }

    /**
     * Show the form for create/update of the given resource.
     *
     * @param \Rinvex\Contacts\Contracts\ContactContract $contact
     *
     * @return \Illuminate\Http\Response
     */
    public function form(ContactContract $contact)
    {
        $countries = countries();
        $languages = collect(languages())->pluck('name', 'iso_639_1');
        $sources = app('rinvex.contacts.contact')->distinct()->get(['source'])->pluck('source', 'source')->toArray();
        $methods = app('rinvex.contacts.contact')->distinct()->get(['method'])->pluck('method', 'method')->toArray();
        $genders = ['m' => trans('cortex/contacts::common.male'), 'f' => trans('cortex/contacts::common.female')];

        return view('cortex/contacts::tenantarea.forms.contact', compact('contact', 'genders', 'countries', 'languages', 'sources', 'methods'));
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Http\Request                   $request
     * @param \Rinvex\Contacts\Contracts\ContactContract $contact
     *
     * @return \Illuminate\Http\Response
     */
    protected function process(Request $request, ContactContract $contact)
    {
        // Prepare required input fields
        $data = $request->all();

        // Save contact
        $contact->fill($data)->save();
        $contact->attachTenants(config('rinvex.tenants.tenant.active'));

        return intend([
            'url' => route('tenantarea.contacts.index'),
            'with' => ['success' => trans('cortex/contacts::messages.contact.saved', ['slug' => $contact->slug])],
        ]);
    }
}