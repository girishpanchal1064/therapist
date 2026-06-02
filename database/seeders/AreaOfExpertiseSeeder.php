<?php

namespace Database\Seeders;

use App\Models\AreaOfExpertise;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AreaOfExpertiseSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            ['name' => 'Anxiety Management', 'icon' => 'ri-mental-health-line', 'sort_order' => 1],
            ['name' => 'Depression Support', 'icon' => 'ri-heart-pulse-line', 'sort_order' => 2],
            ['name' => 'Relationship Counseling', 'icon' => 'ri-group-line', 'sort_order' => 3],
            ['name' => 'Stress Management', 'icon' => 'ri-sun-foggy-line', 'sort_order' => 4],
            ['name' => 'Trauma & PTSD', 'icon' => 'ri-shield-check-line', 'sort_order' => 5],
            ['name' => 'Child & Adolescent Therapy', 'icon' => 'ri-parent-line', 'sort_order' => 6],
            ['name' => 'Family Counseling', 'icon' => 'ri-home-heart-line', 'sort_order' => 7],
            ['name' => 'Addiction Recovery', 'icon' => 'ri-refresh-line', 'sort_order' => 8],
            ['name' => 'Career Guidance', 'icon' => 'ri-briefcase-4-line', 'sort_order' => 9],
            ['name' => 'Sleep Disorders', 'icon' => 'ri-moon-clear-line', 'sort_order' => 10],
        ];

        foreach ($areas as $area) {
            AreaOfExpertise::updateOrCreate(
                ['slug' => Str::slug($area['name'])],
                [
                    'name' => $area['name'],
                    'description' => $area['name'],
                    'icon' => $area['icon'],
                    'sort_order' => $area['sort_order'],
                    'is_active' => true,
                ]
            );
        }
    }
}
