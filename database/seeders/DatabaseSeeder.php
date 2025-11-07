<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  public function run(): void
  {
      $this->call([
        RoleSeeder::class,
        RoleAndPermissionSeeder::class,
        //SuperAdminSeeder::class,
        UserSeeder::class,
        AssessmentSeeder::class,
        BlogSeeder::class,
        TherapistSpecializationSeeder::class,
      ]);
  }
}
