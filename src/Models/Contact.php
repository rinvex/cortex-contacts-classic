<?php

declare(strict_types=1);

namespace Cortex\Contacts\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use Rinvex\Contacts\Models\Contact as BaseContact;

/**
 * Cortex\Contacts\Models\Contact.
 *
 * @property int                                                                             $id
 * @property int                                                                             $entity_id
 * @property string                                                                          $entity_type
 * @property string                                                                          $source
 * @property string                                                                          $method
 * @property string                                                                          $name_prefix
 * @property string                                                                          $first_name
 * @property string                                                                          $middle_name
 * @property string                                                                          $last_name
 * @property string                                                                          $name_suffix
 * @property string                                                                          $job_title
 * @property string                                                                          $email
 * @property string                                                                          $phone
 * @property string                                                                          $fax
 * @property string                                                                          $skype
 * @property string                                                                          $twitter
 * @property string                                                                          $facebook
 * @property string                                                                          $google_plus
 * @property string                                                                          $linkedin
 * @property string                                                                          $country_code
 * @property string                                                                          $language_code
 * @property string                                                                          $birthday
 * @property string                                                                          $gender
 * @property \Carbon\Carbon                                                                  $created_at
 * @property \Carbon\Carbon                                                                  $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Foundation\Models\Log[]   $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rinvex\Contacts\Models\Contact[] $backRelatives
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent                              $entity
 * @property-read string                                                                     $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rinvex\Contacts\Models\Contact[] $relatives
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact country($countryCode)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact language($languageCode)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact method($method)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Contacts\Models\Contact source($source)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereEntityType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereGooglePlus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereJobTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereLanguageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereLinkedin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereNamePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereNameSuffix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereSkype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Contacts\Models\Contact whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
