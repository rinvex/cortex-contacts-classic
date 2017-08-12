<?php

declare(strict_types=1);

namespace Cortex\Contacts\Http\Controllers\Backend;

use Cortex\Fort\Models\User;
use Illuminate\Http\Request;
use Cortex\Contacts\Models\Contact;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Contacts\DataTables\Backend\ContactsDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Contacts\Http\Requests\Backend\ContactFormRequest;

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
        ])->render('cortex/foundation::backend.partials.datatable');
    }

    /**
     * Display a listing of the resource logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function logs(Contact $contact)
    {
        return app(LogsDataTable::class)->with([
            'type' => 'contacts',
            'resource' => $contact,
            'id' => 'cortex-contacts-logs',
            'phrase' => trans('cortex/contacts::common.contacts'),
        ])->render('cortex/foundation::backend.partials.datatable-logs');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Contacts\Http\Requests\Backend\ContactFormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ContactFormRequest $request)
    {
        return $this->process($request, new Contact());
    }

    /**
     * Update the given resource in storage.
     *
     * @param \Cortex\Contacts\Http\Requests\Backend\ContactFormRequest $request
     * @param \Cortex\Contacts\Models\Contact                           $contact
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ContactFormRequest $request, Contact $contact)
    {
        return $this->process($request, $contact);
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Cortex\Contacts\Models\Contact $contact
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Contact $contact)
    {
        $contact->delete();

        return intend([
            'url' => route('backend.contacts.index'),
            'with' => ['warning' => trans('cortex/contacts::messages.contact.deleted', ['contactId' => $contact->id])],
        ]);
    }

    /**
     * Show the form for create/update of the given resource.
     *
     * @param \Cortex\Contacts\Models\Contact $contact
     *
     * @return \Illuminate\Http\Response
     */
    public function form(Contact $contact)
    {
        $countries = countries();
        $languages = collect(languages())->pluck('name', 'iso_639_1');
        $sources = Contact::distinct()->get(['source'])->pluck('source', 'source')->toArray();
        $methods = Contact::distinct()->get(['method'])->pluck('method', 'method')->toArray();
        $genders = ['m' => trans('cortex/fort::common.male'), 'f' => trans('cortex/fort::common.female')];

        return view('cortex/contacts::backend.forms.contact', compact('contact', 'genders', 'countries', 'languages', 'sources', 'methods'));
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Http\Request         $request
     * @param \Cortex\Contacts\Models\Contact $contact
     *
     * @return \Illuminate\Http\Response
     */
    protected function process(Request $request, Contact $contact)
    {
        // Prepare required input fields
        $data = $request->all();

        // Save contact
        $contact->fill($data)->save();

        return intend([
            'url' => route('backend.contacts.index'),
            'with' => ['success' => trans('cortex/contacts::messages.contact.saved', ['contactId' => $contact->id])],
        ]);
    }
}
