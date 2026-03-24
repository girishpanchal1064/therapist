<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{

    public function run(): void
    {
        $guard = config('auth.defaults.guard', 'web');

        foreach (['SuperAdmin', 'Admin', 'Therapist', 'Client'] as $name) {
            Role::firstOrCreate(
                ['name' => $name, 'guard_name' => $guard]
            );
        }
    }
}
