<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = \Spatie\Permission\Models\Role::where('name', 'SuperAdmin')->first();
        $adminRole = \Spatie\Permission\Models\Role::where('name', 'Admin')->first();
        $therapistRole = \Spatie\Permission\Models\Role::where('name', 'Therapist')->first();
        $clientRole = \Spatie\Permission\Models\Role::where('name', 'Client')->first();

        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@therapist.local'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role_id' => $superAdminRole ? $superAdminRole->id : null,
                'phone' => '+1234567890',
                'status' => 'active',
            ]
        );
        $superAdmin->assignRole('SuperAdmin');

        $admin = User::firstOrCreate(
            ['email' => 'admin@therapist.local'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role_id' => $adminRole ? $adminRole->id : null,
                'phone' => '+1234567890',
                'status' => 'active',
            ]
        );
        $admin->assignRole('Admin');

        $therapist = User::firstOrCreate(
            ['email' => 'therapist@therapist.local'],
            [
                'name' => 'Therapist',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role_id' => $therapistRole ? $therapistRole->id : null,
                'phone' => '+1234567890',
                'status' => 'active',
            ]
        );
        $therapist->assignRole('Therapist');

        $client = User::firstOrCreate(
            ['email' => 'client@therapist.local'],
            [
                'name' => 'Client User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role_id' => $clientRole ? $clientRole->id : null,
                'phone' => '+1234567890',
                'status' => 'active',
            ]
        );
        $client->assignRole('Client');
    }
}
