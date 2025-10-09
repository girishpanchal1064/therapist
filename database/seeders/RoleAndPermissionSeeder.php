<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // User management
            'view users',
            'create users',
            'edit users',
            'delete users',
            'suspend users',
            'activate users',

            // Therapist management
            'view therapists',
            'create therapists',
            'edit therapists',
            'delete therapists',
            'verify therapists',
            'approve therapists',
            'reject therapists',

            // Appointment management
            'view appointments',
            'create appointments',
            'edit appointments',
            'delete appointments',
            'cancel appointments',
            'reschedule appointments',
            'complete appointments',

            // Payment management
            'view payments',
            'process payments',
            'refund payments',
            'view financial reports',

            // Content management
            'view blog posts',
            'create blog posts',
            'edit blog posts',
            'delete blog posts',
            'publish blog posts',

            // Assessment management
            'view assessments',
            'create assessments',
            'edit assessments',
            'delete assessments',
            'view assessment results',

            // Review management
            'view reviews',
            'approve reviews',
            'reject reviews',
            'delete reviews',

            // Settings management
            'view settings',
            'edit settings',
            'view system logs',

            // Client specific permissions
            'book appointments',
            'view own appointments',
            'cancel own appointments',
            'reschedule own appointments',
            'view own profile',
            'edit own profile',
            'view own messages',
            'send messages',
            'view own assessments',
            'take assessments',
            'view own reviews',
            'create reviews',

            // Therapist specific permissions
            'view own appointments',
            'manage own availability',
            'view own clients',
            'view own earnings',
            'manage own profile',
            'view own reviews',
            'respond to reviews',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $therapistRole = Role::firstOrCreate(['name' => 'therapist']);
        $clientRole = Role::firstOrCreate(['name' => 'client']);
        $corporateAdminRole = Role::firstOrCreate(['name' => 'corporate_admin']);

        // Assign permissions to super admin role (full access)
        $superAdminRole->givePermissionTo(Permission::all());

        // Assign permissions to admin role
        $adminRole->givePermissionTo([
            'view users', 'create users', 'edit users', 'delete users', 'suspend users', 'activate users',
            'view therapists', 'create therapists', 'edit therapists', 'delete therapists', 'verify therapists', 'approve therapists', 'reject therapists',
            'view appointments', 'create appointments', 'edit appointments', 'delete appointments', 'cancel appointments', 'reschedule appointments', 'complete appointments',
            'view payments', 'process payments', 'refund payments', 'view financial reports',
            'view blog posts', 'create blog posts', 'edit blog posts', 'delete blog posts', 'publish blog posts',
            'view assessments', 'create assessments', 'edit assessments', 'delete assessments', 'view assessment results',
            'view reviews', 'approve reviews', 'reject reviews', 'delete reviews',
            'view settings', 'edit settings', 'view system logs',
        ]);

        // Assign permissions to therapist role
        $therapistRole->givePermissionTo([
            'view own appointments', 'manage own availability', 'view own clients', 'view own earnings', 'manage own profile',
            'view own reviews', 'respond to reviews', 'view own messages', 'send messages',
        ]);

        // Assign permissions to client role
        $clientRole->givePermissionTo([
            'book appointments', 'view own appointments', 'cancel own appointments', 'reschedule own appointments',
            'view own profile', 'edit own profile', 'view own messages', 'send messages',
            'view own assessments', 'take assessments', 'view own reviews', 'create reviews',
        ]);

        // Assign permissions to corporate admin role
        $corporateAdminRole->givePermissionTo([
            'view users', 'create users', 'edit users', 'view appointments', 'view payments',
            'view own profile', 'edit own profile',
        ]);
    }
}
