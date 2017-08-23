<?php

declare(strict_types=1);

namespace Cortex\Contacts\DataTables\Backend;

use Rinvex\Contacts\Contracts\ContactContract;
use Cortex\Foundation\DataTables\AbstractDataTable;
use Cortex\Contacts\Transformers\Backend\ContactTransformer;

class ContactsDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = ContactContract::class;

    /**
     * {@inheritdoc}
     */
    protected $transformer = ContactTransformer::class;

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'first_name' => ['title' => trans('cortex/contacts::common.first_name'), 'render' => '"<a href=\""+routes.route(\'backend.contacts.edit\', {contact: full.id})+"\">"+data+"</a>"', 'responsivePriority' => 0],
            'middle_name' => ['title' => trans('cortex/contacts::common.middle_name')],
            'last_name' => ['title' => trans('cortex/contacts::common.last_name')],
            'email' => ['title' => trans('cortex/contacts::common.email')],
            'phone' => ['title' => trans('cortex/contacts::common.phone')],
            'country_code' => ['title' => trans('cortex/contacts::common.country')],
            'language_code' => ['title' => trans('cortex/contacts::common.language')],
            'source' => ['title' => trans('cortex/contacts::common.source')],
            'method' => ['title' => trans('cortex/contacts::common.method')],
            'created_at' => ['title' => trans('cortex/contacts::common.created_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
            'updated_at' => ['title' => trans('cortex/contacts::common.updated_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
        ];
    }
}
