<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create SuperAdmin role if it doesn't exist
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);

        // Create SuperAdmin user
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@therapist.com'],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@therapist.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567890',
                'status' => 'active',
                'profile_completed' => true,
            ]
        );

        // Assign SuperAdmin role
        if (!$superAdmin->hasRole('super_admin')) {
            $superAdmin->assignRole('super_admin');
        }

        // Create Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@therapist.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@therapist.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567891',
                'status' => 'active',
                'profile_completed' => true,
            ]
        );

        // Assign Admin role
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Create Therapist user
        $therapist = User::firstOrCreate(
            ['email' => 'therapist@therapist.com'],
            [
                'name' => 'Test Therapist',
                'email' => 'therapist@therapist.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567892',
                'status' => 'active',
                'profile_completed' => true,
            ]
        );

        // Assign Therapist role
        if (!$therapist->hasRole('therapist')) {
            $therapist->assignRole('therapist');
        }

        $this->command->info('SuperAdmin, Admin, and Therapist users created successfully!');
        $this->command->info('SuperAdmin: superadmin@therapist.com / password');
        $this->command->info('Admin: admin@therapist.com / password');
        $this->command->info('Therapist: therapist@therapist.com / password');
    }
}
