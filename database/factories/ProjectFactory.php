<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_name' => $this->faker->sentence(3),
            'project_volume' => $this->faker->numberBetween(10, 1000),
            'project_file' => $this->faker->word . '.pdf',
            'project_rate' => $this->faker->randomFloat(2, 10, 1000),
            'qc_rate' => $this->faker->randomFloat(2, 5, 500),
            'bonuses' => $this->faker->randomFloat(2, 0, 200),
            'status' => $this->faker->randomElement(['waiting talent', 'in progress', 'completed', 'cancelled']),
            'start_date' => $this->faker->date(),
            'finish_date' => $this->faker->optional(0.7)->date(), // 70% chance of having a finish date
            // user_id, company_id, project_type_id, talent, and qc_agent will be set in the seeder
        ];
    }
}
