<?php

declare(strict_types=1);

namespace Cortex\Contacts\Models;

use Rinvex\Contacts\Contact as BaseContact;
use Spatie\Activitylog\Traits\LogsActivity;

class Contact extends BaseContact
{
    use LogsActivity;

    /**
     * Indicates whether to log only dirty attributes or all.
     *
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * The attributes that are logged on change.
     *
     * @var array
     */
    protected static $logAttributes = [
        'entity_id',
        'entity_type',
        'source',
        'method',
        'name_prefix',
        'first_name',
        'middle_name',
        'last_name',
        'name_suffix',
        'job_title',
        'email',
        'phone',
        'fax',
        'skype',
        'twitter',
        'facebook',
        'google_plus',
        'linkedin',
        'country_code',
        'language_code',
        'birthday',
        'gender',
    ];

    /**
     * The attributes that are ignored on change.
     *
     * @var array
     */
    protected static $ignoreChangedAttributes = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
