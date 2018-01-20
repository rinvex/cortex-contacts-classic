<?php

declare(strict_types=1);

namespace Cortex\Contacts\Transformers\Managerarea;

use League\Fractal\TransformerAbstract;
use Rinvex\Contacts\Models\Contact;

class ContactTransformer extends TransformerAbstract
{
    /**
     * @return array
     */
    public function transform(Contact $contact): array
    {
        return [
            'id' => (int) $contact->getKey(),
            'first_name' => (string) $contact->first_name,
            'middle_name' => (string) $contact->middle_name,
            'last_name' => (string) $contact->last_name,
            'email' => (string) $contact->email,
            'phone' => (string) $contact->phone,
            'country_code' => (string) $contact->country_code ? country($contact->country_code)->getName().'&nbsp;&nbsp;'.country($contact->language_code)->getEmoji() : '',
            'language_code' => (string) $contact->language_code ? language($contact->language_code)->getName() : '',
            'source' => (string) $contact->source,
            'method' => (string) $contact->method,
            'created_at' => (string) $contact->created_at,
            'updated_at' => (string) $contact->updated_at,
        ];
    }
}
