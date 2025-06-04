<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Talent;
use App\Models\Project;
use App\Models\ProjectType;

class CompanyTalentProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users
        $companyUsers = User::factory()->count(5)->create(['role' => 'company']);
        $talentUsers = User::factory()->count(20)->create(['role' => 'talent']);
        $adminUser = User::factory()->create(['role' => 'superadmin']);

        // Create companies associated with company users
        $companies = $companyUsers->each(function ($user) {
            Company::factory()->create(['user_id' => $user->id]);
        });

        // Create talents associated with talent users
        $talents = $talentUsers->each(function ($user) {
            Talent::factory()->create(['user_id' => $user->id]);
        });

        // Get some project types (assuming you have a ProjectType seeder or factory)
        // If you don't have project types, you might need to create some here first.
        $projectTypes = ProjectType::factory()->count(5)->create();

        // Create projects
        Project::factory()->count(50)->create([
            'company_id' => $companies->random()->id,
            'project_type_id' => $projectTypes->random()->id,
            'talent' => $talents->random()->user_id, // Link to the user_id of a talent
            'qc_agent' => $talentUsers->random()->id, // Link to the user_id of a talent for QC
            'user_id' => $companies->random()->user_id, // Link to the user_id of a company user who created the project
        ]);
    }
}
