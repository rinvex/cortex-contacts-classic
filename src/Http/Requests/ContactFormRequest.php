<?php

declare(strict_types=1);

namespace Cortex\Contacts\Http\Requests\Backend;

use Cortex\Contacts\Models\Contact;
use Rinvex\Support\Http\Requests\FormRequest;

class ContactFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Process given request data before validation.
     *
     * @param array $data
     *
     * @return array
     */
    public function process($data)
    {
        $data['entity_id'] = $this->user()->id;
        $data['entity_type'] = get_class($this->user());

        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $contact = $this->route('contact') ?? new Contact();
        $contact->updateRulesUniques();

        return $contact->getRules();
    }
}
