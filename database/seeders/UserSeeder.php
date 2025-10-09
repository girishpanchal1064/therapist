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
      $admin = User::firstOrCreate(
        ['email' => 'admin@therapist.local'],
        [
          'name' => 'Super Admin',
          'password' => Hash::make('password'),
          'email_verified_at' => now(),
        ]
      );
      $admin->assignRole('Admin');

      // --- Create Therapist User ---
      $therapist = User::firstOrCreate(
        ['email' => 'therapist@therapist.local'],
        [
          'name' => 'Demo Therapist',
          'password' => Hash::make('password'),
          'email_verified_at' => now(),
        ]
      );
      $therapist->assignRole('Therapist');
    }
}
