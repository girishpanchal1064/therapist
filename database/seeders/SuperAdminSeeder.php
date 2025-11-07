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
        $superAdmin->assignRole('SuperAdmin');

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
        $admin->assignRole('Admin');

        $therapist = User::firstOrCreate(
            ['email' => 'therapist@therapist.com'],
            [
                'name' => 'Therapist',
                'email' => 'therapist@therapist.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567892',
                'status' => 'active',
                'profile_completed' => true,
            ]
        );

      $therapist->assignRole('Therapist');
    }
}
