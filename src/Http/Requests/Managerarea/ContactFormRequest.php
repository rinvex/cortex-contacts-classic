<?php

declare(strict_types=1);

namespace Cortex\Contacts\Http\Requests\Managerarea;

use Rinvex\Support\Traits\Escaper;
use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    use Escaper;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $data = $this->all();

        $data['entity_id'] = $this->user($this->route('guard'))->getKey();
        $data['entity_type'] = $this->user($this->route('guard'))->getMorphClass();

        $this->replace($data);
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return void
     */
    public function withValidator($validator): void
    {
        // Sanitize input data before submission
        $this->replace($this->escape($this->all()));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $contact = $this->route('contact') ?? app('rinvex.contacts.contact');
        $contact->updateRulesUniques();

        return $contact->getRules();
    }
}
