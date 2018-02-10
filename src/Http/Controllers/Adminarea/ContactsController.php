<?php

declare(strict_types=1);

namespace Cortex\Contacts\Http\Controllers\Adminarea;

use Rinvex\Contacts\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Contacts\DataTables\Adminarea\ContactsDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Contacts\Http\Requests\Adminarea\ContactFormRequest;

class ContactsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'contact';

    /**
     * Display a listing of the resource.
     *
     * @param \Cortex\Contacts\DataTables\Adminarea\ContactsDataTable $contactsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(ContactsDataTable $contactsDataTable)
    {
        return $contactsDataTable->with([
            'id' => 'adminarea-contacts-index-table',
            'phrase' => trans('cortex/contacts::common.contacts'),
        ])->render('cortex/foundation::adminarea.pages.datatable');
    }

    /**
     * Get a listing of the resource logs.
     *
     * @param \Rinvex\Contacts\Models\Contact $contact
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function logs(Contact $contact, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'resource' => $contact,
            'tabs' => 'adminarea.contacts.tabs',
            'phrase' => trans('cortex/contacts::common.contacts'),
            'id' => "adminarea-contacts-{$contact->getKey()}-logs-table",
        ])->render('cortex/foundation::adminarea.pages.datatable-logs');
    }

    /**
     * Show the form for create/update of the given resource.
     *
     * @param \Rinvex\Contacts\Models\Contact $contact
     *
     * @return \Illuminate\View\View
     */
    public function form(Contact $contact)
    {
        $countries = collect(countries())->map(function ($country, $code) {
            return [
                'id' => $code,
                'text' => $country['name'],
                'emoji' => $country['emoji'],
            ];
        })->values();
        $languages = collect(languages())->pluck('name', 'iso_639_1');
        $sources = app('rinvex.contacts.contact')->distinct()->get(['source'])->pluck('source', 'source')->toArray();
        $methods = app('rinvex.contacts.contact')->distinct()->get(['method'])->pluck('method', 'method')->toArray();
        $genders = ['male' => trans('cortex/contacts::common.male'), 'female' => trans('cortex/contacts::common.female')];
        $logs = app(LogsDataTable::class)->with(['id' => "adminarea-contacts-{$contact->getKey()}-logs-table"])->html()->minifiedAjax(route('adminarea.contacts.logs', ['contact' => $contact]));

        return view('cortex/contacts::adminarea.pages.contact', compact('contact', 'genders', 'countries', 'languages', 'sources', 'methods', 'logs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Contacts\Http\Requests\Adminarea\ContactFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(ContactFormRequest $request)
    {
        return $this->process($request, app('rinvex.contacts.contact'));
    }

    /**
     * Update the given resource in storage.
     *
     * @param \Cortex\Contacts\Http\Requests\Adminarea\ContactFormRequest $request
     * @param \Rinvex\Contacts\Models\Contact                             $contact
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(ContactFormRequest $request, Contact $contact)
    {
        return $this->process($request, $contact);
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Rinvex\Contacts\Models\Contact         $contact
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function process(FormRequest $request, Contact $contact)
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save contact
        $contact->fill($data)->save();

        return intend([
            'url' => route('adminarea.contacts.index'),
            'with' => ['success' => trans('cortex/contacts::messages.contact.saved', ['slug' => $contact->slug])],
        ]);
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Rinvex\Contacts\Models\Contact $contact
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function delete(Contact $contact)
    {
        $contact->delete();

        return intend([
            'url' => route('adminarea.contacts.index'),
            'with' => ['warning' => trans('cortex/contacts::messages.contact.deleted', ['slug' => $contact->slug])],
        ]);
    }
}
