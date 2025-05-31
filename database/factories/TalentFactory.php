<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Talent;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Talent>
 */
class TalentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'date_of_birth' => $this->faker->date(),
            'id_card' => $this->faker->unique()->numerify('##############'), // Example: 14 digits
            'bank_name' => $this->faker->word . ' Bank',
            'bank_account' => $this->faker->unique()->numerify('##########'), // Example: 10 digits
            'swift_code' => $this->faker->swiftBicNumber,
            'subjected_tax' => $this->faker->boolean,
            // user_id will be set in the seeder
        ];
    }
}
