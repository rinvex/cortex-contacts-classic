<?php

declare(strict_types=1);

namespace Cortex\Contacts\Http\Controllers\Adminarea;

use Exception;
use Illuminate\Http\Request;
use Cortex\Contacts\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Importers\DefaultImporter;
use Cortex\Foundation\DataTables\ImportLogsDataTable;
use Cortex\Foundation\Http\Requests\ImportFormRequest;
use Cortex\Foundation\DataTables\ImportRecordsDataTable;
use Cortex\Contacts\DataTables\Adminarea\ContactsDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Contacts\Http\Requests\Adminarea\ContactFormRequest;

class ContactsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = Contact::class;

    /**
     * List all contacts.
     *
     * @param \Cortex\Contacts\DataTables\Adminarea\ContactsDataTable $contactsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(ContactsDataTable $contactsDataTable)
    {
        return $contactsDataTable->with([
            'id' => 'adminarea-contacts-index',
        ])->render('cortex/foundation::adminarea.pages.datatable-index');
    }

    /**
     * List contact logs.
     *
     * @param \Cortex\Contacts\Models\Contact             $contact
     * @param \Cortex\Foundation\DataTables\LogsDataTable $logsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function logs(Contact $contact, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'resource' => $contact,
            'tabs' => 'adminarea.contacts.tabs',
            'id' => "adminarea-contacts-{$contact->getRouteKey()}-logs",
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
    }

    /**
     * Import contacts.
     *
     * @param \Cortex\Contacts\Models\Contact                      $contact
     * @param \Cortex\Foundation\DataTables\ImportRecordsDataTable $importRecordsDataTable
     *
     * @return \Illuminate\View\View
     */
    public function import(Contact $contact, ImportRecordsDataTable $importRecordsDataTable)
    {
        return $importRecordsDataTable->with([
            'resource' => $contact,
            'tabs' => 'adminarea.contacts.tabs',
            'url' => route('adminarea.contacts.stash'),
            'id' => "adminarea-contacts-{$contact->getRouteKey()}-import",
        ])->render('cortex/foundation::adminarea.pages.datatable-dropzone');
    }

    /**
     * Stash contacts.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     * @param \Cortex\Foundation\Importers\DefaultImporter       $importer
     *
     * @return void
     */
    public function stash(ImportFormRequest $request, Contact $contact, DefaultImporter $importer)
    {
        // Handle the import
        $importer->config['resource'] = $contact;
        $importer->handleImport();
    }

    /**
     * Hoard contacts.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function hoard(ImportFormRequest $request)
    {
        foreach ((array) $request->get('selected_ids') as $recordId) {
            $record = app('cortex.foundation.import_record')->find($recordId);

            try {
                $fillable = collect($record['data'])->intersectByKeys(array_flip(app('rinvex.contacts.contact')->getFillable()))->toArray();

                tap(app('rinvex.contacts.contact')->firstOrNew($fillable), function ($instance) use ($record) {
                    $instance->save() && $record->delete();
                });
            } catch (Exception $exception) {
                $record->notes = $exception->getMessage().(method_exists($exception, 'getMessageBag') ? "\n".json_encode($exception->getMessageBag())."\n\n" : '');
                $record->status = 'fail';
                $record->save();
            }
        }

        return intend([
            'back' => true,
            'with' => ['success' => trans('cortex/foundation::messages.import_complete')],
        ]);
    }

    /**
     * List contact import logs.
     *
     * @param \Cortex\Foundation\DataTables\ImportLogsDataTable $importLogsDatatable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function importLogs(ImportLogsDataTable $importLogsDatatable)
    {
        return $importLogsDatatable->with([
            'resource' => trans('cortex/contacts::common.contact'),
            'tabs' => 'adminarea.contacts.tabs',
            'id' => 'adminarea-contacts-import-logs',
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
    }

    /**
     * Create new contact.
     *
     * @param \Illuminate\Http\Request        $request
     * @param \Cortex\Contacts\Models\Contact $contact
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request, Contact $contact)
    {
        return $this->form($request, $contact);
    }

    /**
     * Edit given contact.
     *
     * @param \Illuminate\Http\Request        $request
     * @param \Cortex\Contacts\Models\Contact $contact
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, Contact $contact)
    {
        return $this->form($request, $contact);
    }

    /**
     * Show contact create/edit form.
     *
     * @param \Illuminate\Http\Request        $request
     * @param \Cortex\Contacts\Models\Contact $contact
     *
     * @return \Illuminate\View\View
     */
    protected function form(Request $request, Contact $contact)
    {
        $countries = collect(countries())->map(function ($country, $code) {
            return [
                'id' => $code,
                'text' => $country['name'],
                'emoji' => $country['emoji'],
            ];
        })->values();

        $tags = app('rinvex.tags.tag')->pluck('name', 'id');
        $languages = collect(languages())->pluck('name', 'iso_639_1');
        $sources = app('rinvex.contacts.contact')->distinct()->get(['source'])->pluck('source', 'source')->toArray();
        $methods = app('rinvex.contacts.contact')->distinct()->get(['method'])->pluck('method', 'method')->toArray();
        $genders = ['male' => trans('cortex/contacts::common.male'), 'female' => trans('cortex/contacts::common.female')];

        return view('cortex/contacts::adminarea.pages.contact', compact('contact', 'genders', 'countries', 'languages', 'sources', 'methods', 'tags'));
    }

    /**
     * Store new contact.
     *
     * @param \Cortex\Contacts\Http\Requests\Adminarea\ContactFormRequest $request
     * @param \Cortex\Contacts\Models\Contact                             $contact
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(ContactFormRequest $request, Contact $contact)
    {
        return $this->process($request, $contact);
    }

    /**
     * Update given contact.
     *
     * @param \Cortex\Contacts\Http\Requests\Adminarea\ContactFormRequest $request
     * @param \Cortex\Contacts\Models\Contact                             $contact
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(ContactFormRequest $request, Contact $contact)
    {
        return $this->process($request, $contact);
    }

    /**
     * Process stored/updated contact.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\Contacts\Models\Contact         $contact
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
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => trans('cortex/contacts::common.contact'), 'identifier' => $contact->getRouteKey()])],
        ]);
    }

    /**
     * Destroy given contact.
     *
     * @param \Cortex\Contacts\Models\Contact $contact
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return intend([
            'url' => route('adminarea.contacts.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => trans('cortex/contacts::common.contact'), 'identifier' => $contact->getRouteKey()])],
        ]);
    }
}
