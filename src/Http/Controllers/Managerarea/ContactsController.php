<?php

declare(strict_types=1);

namespace Cortex\Contacts\Http\Controllers\Managerarea;

use Illuminate\Foundation\Http\FormRequest;
use Rinvex\Contacts\Contracts\ContactContract;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Contacts\DataTables\Managerarea\ContactsDataTable;
use Cortex\Contacts\Http\Requests\Managerarea\ContactFormRequest;

class ContactsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'contacts';

    /**
     * Display a listing of the resource.
     *
     * @param \Cortex\Contacts\DataTables\Managerarea\ContactsDataTable $contactsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(ContactsDataTable $contactsDataTable)
    {
        return $contactsDataTable->with([
            'id' => 'managerarea-contacts-index-table',
            'phrase' => trans('cortex/contacts::common.contacts'),
        ])->render('cortex/tenants::managerarea.pages.datatable');
    }

    /**
     * Get a listing of the resource logs.
     *
     * @param \Rinvex\Contacts\Contracts\ContactContract $contact
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logs(ContactContract $contact)
    {
        return request()->ajax() && request()->wantsJson()
            ? app(LogsDataTable::class)->with(['resource' => $contact])->ajax()
            : intend(['url' => route('adminarea.contacts.edit', ['contact' => $contact]).'#logs-tab']);
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
        $logs = app(LogsDataTable::class)->with(['id' => "managerarea-contacts-{$contact->getKey()}-logs-table"])->html()->minifiedAjax(route('managerarea.contacts.logs', ['contact' => $contact]));

        return view('cortex/contacts::managerarea.pages.contact', compact('contact', 'genders', 'countries', 'languages', 'sources', 'methods', 'logs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Contacts\Http\Requests\Managerarea\ContactFormRequest $request
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
     * @param \Cortex\Contacts\Http\Requests\Managerarea\ContactFormRequest $request
     * @param \Rinvex\Contacts\Contracts\ContactContract                    $contact
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ContactFormRequest $request, ContactContract $contact)
    {
        return $this->process($request, $contact);
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Foundation\Http\FormRequest    $request
     * @param \Rinvex\Contacts\Contracts\ContactContract $contact
     *
     * @return \Illuminate\Http\Response
     */
    protected function process(FormRequest $request, ContactContract $contact)
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save contact
        $contact->fill($data)->save();

        return intend([
            'url' => route('managerarea.contacts.index'),
            'with' => ['success' => trans('cortex/contacts::messages.contact.saved', ['slug' => $contact->slug])],
        ]);
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
            'url' => route('managerarea.contacts.index'),
            'with' => ['warning' => trans('cortex/contacts::messages.contact.deleted', ['slug' => $contact->slug])],
        ]);
    }
}
