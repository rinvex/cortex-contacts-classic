<?php

declare(strict_types=1);

namespace Cortex\Contacts\Models;

use Rinvex\Tags\Traits\Taggable;
use Rinvex\Tenants\Traits\Tenantable;
use Cortex\Foundation\Traits\Auditable;
use Rinvex\Support\Traits\HashidsTrait;
use Cortex\Foundation\Events\ModelCreated;
use Cortex\Foundation\Events\ModelDeleted;
use Cortex\Foundation\Events\ModelUpdated;
use Cortex\Foundation\Events\ModelRestored;
use Spatie\Activitylog\Traits\LogsActivity;
use Rinvex\Support\Traits\HasSocialAttributes;
use Rinvex\Contacts\Models\Contact as BaseContact;
use Cortex\Foundation\Traits\FiresCustomModelEvent;

/**
 * Cortex\Contacts\Models\Contact.
 *
 * @property int                                                                             $id
 * @property int                                                                             $entity_id
 * @property string                                                                          $entity_type
 * @property string                                                                          $given_name
 * @property string                                                                          $family_name
 * @property string                                                                          $full_name
 * @property string                                                                          $title
 * @property string                                                                          $organization
 * @property string                                                                          $email
 * @property string                                                                          $phone
 * @property string                                                                          $fax
 * @property string                                                                          $country_code
 * @property string                                                                          $language_code
 * @property string                                                                          $birthday
 * @property string                                                                          $gender
 * @property array                                                                           $social
 * @property string                                                                          $national_id_type
 * @property string                                                                          $national_id
 * @property string                                                                          $source
 * @property string                                                                          $method
 * @property string                                                                          $notes
 * @property \Carbon\Carbon|null                                                             $created_at
 * @property \Carbon\Carbon|null                                                             $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Foundation\Models\Log[]   $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Contacts\Models\Contact[] $backRelatives
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent                              $entity
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Contacts\Models\Contact[] $relatives
 * @property \Illuminate\Database\Eloquent\Collection|\Cortex\Tenants\Models\Tenant[]        $tenants
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact country($countryCode)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact language($languageCode)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact method($method)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereEntityType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereFamilyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereGivenName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereLanguageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereNationalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereNationalIdType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereOrganization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereSocial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact withAllTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact withAnyTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact withTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact withoutAnyTenants()
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact withoutTenants($tenants, $group = null)
 * @mixin \Eloquent
 */
class Contact extends BaseContact
{
    use Taggable;
    use Auditable;
    use Tenantable;
    use HashidsTrait;
    use LogsActivity;
    use HasSocialAttributes;
    use FiresCustomModelEvent;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'entity_id',
        'entity_type',
        'source',
        'method',
        'given_name',
        'family_name',
        'title',
        'organization',
        'email',
        'phone',
        'fax',
        'country_code',
        'language_code',
        'birthday',
        'gender',
        'social',
        'national_id_type',
        'national_id',
        'source',
        'method',
        'notes',
        'tags',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'entity_id' => 'integer',
        'entity_type' => 'string',
        'given_name' => 'string',
        'family_name' => 'string',
        'title' => 'string',
        'organization' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'fax' => 'string',
        'country_code' => 'string',
        'language_code' => 'string',
        'birthday' => 'string',
        'gender' => 'string',
        'social' => 'array',
        'national_id_type' => 'string',
        'national_id' => 'string',
        'source' => 'string',
        'method' => 'string',
        'notes' => 'string',
        'deleted_at' => 'datetime',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ModelCreated::class,
        'deleted' => ModelDeleted::class,
        'restored' => ModelRestored::class,
        'updated' => ModelUpdated::class,
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [
        'entity_id' => 'required|integer',
        'entity_type' => 'required|string|strip_tags|max:150',
        'given_name' => 'required|string|strip_tags|max:150',
        'family_name' => 'nullable|string|strip_tags|max:150',
        'title' => 'nullable|string|strip_tags|max:150',
        'organization' => 'nullable|string|strip_tags|max:150',
        'email' => 'required|email|min:3|max:150',
        'phone' => 'nullable|phone:AUTO',
        'fax' => 'nullable|string|strip_tags|max:150',
        'country_code' => 'nullable|alpha|size:2|country',
        'language_code' => 'nullable|alpha|size:2|language',
        'birthday' => 'nullable|date_format:Y-m-d',
        'gender' => 'nullable|in:male,female',
        'social' => 'nullable',
        'national_id_type' => 'nullable|in:identification,passport,other',
        'national_id' => 'nullable|string|strip_tags|max:150',
        'source' => 'nullable|string|strip_tags|max:150',
        'method' => 'nullable|string|strip_tags|max:150',
        'notes' => 'nullable|string|strip_tags|max:10000',
        'tags' => 'nullable|array',
    ];

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
    protected static $logFillable = true;

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
