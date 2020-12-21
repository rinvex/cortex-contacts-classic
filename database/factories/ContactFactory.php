<?php

declare(strict_types=1);

namespace Cortex\Contacts\Database\Factories;

use Cortex\Contacts\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'addressable_type' => $this->faker->randomElement(['App\Models\Company', 'App\Models\Product', 'App\Models\User']),
            'addressable_id' => $this->faker->randomNumber(),
            'given_name' => $this->faker->firstName,
            'family_name' => $this->faker->lastName,
            'title' => $this->faker->jobTitle,
            'organization' => $this->faker->company,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'source' => $this->faker->randomElement(['conference', 'random', 'website']),
            'method' => $this->faker->randomElement(['phone', 'email', 'sms']),
            'country_code' => $this->faker->countryCode,
            'language_code' => $this->faker->languageCode,
            'birthday' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['male', 'female']),
        ];
    }
}
