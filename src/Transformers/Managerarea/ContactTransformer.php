<?php

declare(strict_types=1);

namespace Cortex\Contacts\Transformers\Managerarea;

use Rinvex\Support\Traits\Escaper;
use Cortex\Contacts\Models\Contact;
use League\Fractal\TransformerAbstract;

class ContactTransformer extends TransformerAbstract
{
    use Escaper;

    /**
     * @return array
     */
    public function transform(Contact $contact): array
    {
        return $this->escape([
            'id' => (string) $contact->getRouteKey(),
            'full_name' => (string) $contact->full_name,
            'email' => (string) $contact->email,
            'phone' => (string) $contact->phone,
            'country_code' => (string) $contact->country_code ? country($contact->country_code)->getName() : null,
            'language_code' => (string) $contact->language_code ? language($contact->language_code)->getName() : null,
            'source' => (string) $contact->source,
            'method' => (bool) $contact->method,
            'created_at' => (string) $contact->created_at,
            'updated_at' => (string) $contact->updated_at,
        ]);
    }
}
