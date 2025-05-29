<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create SuperAdmin
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin'
        ]);

        // Create Company
        User::factory()->create([
            'name' => 'Company User',
            'email' => 'company@example.com',
            'password' => Hash::make('password'),
            'role' => 'company'
        ]);

        // Create Talent
        User::factory()->create([
            'name' => 'Talent User',
            'email' => 'talent@example.com',
            'password' => Hash::make('password'),
            'role' => 'talent'
        ]);

        // Create Talent QC
        User::factory()->create([
            'name' => 'Talent QC User',
            'email' => 'talentqc@example.com',
            'password' => Hash::make('password'),
            'role' => 'talent_qc'
        ]);

        // Create multiple users for each role (optional)
        // Company Users
        User::factory(3)->create([
            'role' => 'company'
        ]);

        // Talent Users
        User::factory(5)->create([
            'role' => 'talent'
        ]);

        // Talent QC Users
        User::factory(2)->create([
            'role' => 'talent_qc'
        ]);
    }
}
