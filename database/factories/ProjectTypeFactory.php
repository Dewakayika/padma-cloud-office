<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProjectType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectType>
 */
class ProjectTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_name' => $this->faker->unique()->word,
        ];
    }
}
