<?php

declare(strict_types=1);

namespace Cortex\Contacts\DataTables\Managerarea;

use Cortex\Contacts\Models\Contact;
use Cortex\Foundation\DataTables\AbstractDataTable;

class ContactsDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = Contact::class;

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        $link = config('cortex.foundation.route.locale_prefix')
            ? '"<a href=\""+routes.route(\'managerarea.contacts.edit\', {contact: full.id, locale: \''.$this->request->segment(1).'\'})+"\">"+data+"</a>"'
            : '"<a href=\""+routes.route(\'managerarea.contacts.edit\', {contact: full.id})+"\">"+data+"</a>"';

        return [
            'first_name' => ['title' => trans('cortex/contacts::common.first_name'), 'render' => $link, 'responsivePriority' => 0],
            'middle_name' => ['title' => trans('cortex/contacts::common.middle_name'), 'visible' => false],
            'last_name' => ['title' => trans('cortex/contacts::common.last_name')],
            'email' => ['title' => trans('cortex/contacts::common.email')],
            'phone' => ['title' => trans('cortex/contacts::common.phone')],
            'country_code' => ['title' => trans('cortex/contacts::common.country')],
            'language_code' => ['title' => trans('cortex/contacts::common.language'), 'visible' => false],
            'source' => ['title' => trans('cortex/contacts::common.source'), 'visible' => false],
            'method' => ['title' => trans('cortex/contacts::common.method'), 'visible' => false],
            'created_at' => ['title' => trans('cortex/contacts::common.created_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
            'updated_at' => ['title' => trans('cortex/contacts::common.updated_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
        ];
    }
}
