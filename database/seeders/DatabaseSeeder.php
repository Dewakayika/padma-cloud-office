<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\CompanyTalent;
use App\Models\Invitation;
use App\Models\ProjectLog;
use App\Models\ProjectSop;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            // Create SuperAdmin
            $superAdmin = User::factory()->create([
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password'),
                'role' => 'superadmin'
            ]);

            // Create Company Users with Companies
            $companyUsers = collect([
                User::factory()->create([
                    'name' => 'Company User',
                    'email' => 'company@example.com',
                    'password' => Hash::make('password'),
                    'role' => 'company'
                ])
            ]);

            // Create additional company users
            $companyUsers = $companyUsers->merge(
                User::factory(3)->create(['role' => 'company'])
            );

            // Create companies for each company user
            $companies = $companyUsers->map(function ($user) {
                return Company::create([
                    'user_id' => $user->id,
                    'company_name' => fake()->company(),
                    'company_type' => fake()->companySuffix(),
                    'country' => fake()->country(),
                    'contact_person_name' => fake()->name()
                ]);
            });

            // Create Project Types for each company
            foreach ($companies as $company) {
                $projectTypes = [
                    ['project_name' => 'Web Development', 'project_rate' => '50.00'],
                    ['project_name' => 'Mobile Development', 'project_rate' => '60.00'],
                    ['project_name' => 'UI/UX Design', 'project_rate' => '45.00'],
                    ['project_name' => 'Data Analysis', 'project_rate' => '55.00'],
                ];

                foreach ($projectTypes as $type) {
                    ProjectType::create([
                        'user_id' => $company->user_id,
                        'company_id' => $company->id,
                        'project_name' => $type['project_name'],
                        'project_rate' => $type['project_rate']
                    ]);
                }
            }

            // Create Talent Users
            $talentUsers = collect([
                User::factory()->create([
                    'name' => 'Talent User',
                    'email' => 'talent@example.com',
                    'password' => Hash::make('password'),
                    'role' => 'talent'
                ])
            ]);

            // Create additional talent users
            $talentUsers = $talentUsers->merge(
                User::factory(5)->create(['role' => 'talent'])
            );

            // Create Talent QC Users
            $talentQCUsers = collect([
                User::factory()->create([
                    'name' => 'Talent QC User',
                    'email' => 'talentqc@example.com',
                    'password' => Hash::make('password'),
                    'role' => 'talent_qc'
                ])
            ]);

            // Create additional talent QC users
            $talentQCUsers = $talentQCUsers->merge(
                User::factory(2)->create(['role' => 'talent_qc'])
            );

            // Create Company-Talent relationships
            foreach ($companies as $company) {
                // Assign 2-3 talents to each company
                $talentUsers->random(rand(2, 3))->each(function ($talent) use ($company) {
                    CompanyTalent::create([
                        'company_id' => $company->id,
                        'user_id' => $company->user_id,
                        'talent_id' => $talent->id,
                        'job_role' => 'talent'
                    ]);
                });
            }

            // Create Projects for each company
            foreach ($companies as $company) {
                $projectTypes = ProjectType::where('company_id', $company->id)->get();

                // Create 2-4 projects for each company
                Project::factory(rand(2, 4))->create([
                    'user_id' => $company->user_id,
                    'company_id' => $company->id,
                    'project_type_id' => $projectTypes->random()->id,
                    'talent' => $talentUsers->random()->id,
                    'qc_agent' => $talentQCUsers->random()->id,
                    'status' => 'waiting talent'
                ])->each(function ($project) {
                    // Create initial project log
                    ProjectLog::create([
                        'user_id' => $project->user_id,
                        'project_id' => $project->id,
                        'company_id' => $project->company_id,
                        'status' => $project->status,
                        'timestamp' => now(),
                        'talent_id' => $project->talent,
                        'talent_qc_id' => $project->qc_agent
                    ]);
                });
            }

            // Create Project SOPs
            foreach ($companies as $company) {
                $projectTypes = ProjectType::where('company_id', $company->id)->get();

                foreach ($projectTypes as $type) {
                    ProjectSop::create([
                        'user_id' => $company->user_id,
                        'company_id' => $company->id,
                        'project_type_id' => $type->id,
                        'sop_formula' => fake()->paragraph(),
                        'description' => fake()->sentence()
                    ]);
                }
            }

            // Create some invitations
            foreach ($companies as $company) {
                Invitation::create([
                    'company_id' => $company->id,
                    'inviting_user_id' => $company->user_id,
                    'email' => fake()->unique()->safeEmail(),
                    'token' => fake()->uuid(),
                    'expires_at' => now()->addDays(7),
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
