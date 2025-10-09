<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TherapistSpecialization;

class TherapistSpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = [
            [
                'name' => 'Anxiety Disorders',
                'slug' => 'anxiety-disorders',
                'description' => 'Specialized in treating various anxiety disorders including generalized anxiety, panic attacks, and social anxiety.',
                'icon' => 'anxiety',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Depression',
                'slug' => 'depression',
                'description' => 'Expertise in treating depression, mood disorders, and related mental health conditions.',
                'icon' => 'depression',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Relationship Counseling',
                'slug' => 'relationship-counseling',
                'description' => 'Specialized in couple therapy, marriage counseling, and relationship issues.',
                'icon' => 'relationship',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Trauma & PTSD',
                'slug' => 'trauma-ptsd',
                'description' => 'Expertise in trauma therapy, PTSD treatment, and EMDR therapy.',
                'icon' => 'trauma',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Addiction Recovery',
                'slug' => 'addiction-recovery',
                'description' => 'Specialized in substance abuse treatment, addiction recovery, and relapse prevention.',
                'icon' => 'addiction',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Family Therapy',
                'slug' => 'family-therapy',
                'description' => 'Expertise in family dynamics, parenting issues, and family conflict resolution.',
                'icon' => 'family',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Stress Management',
                'slug' => 'stress-management',
                'description' => 'Specialized in stress reduction, work-life balance, and burnout prevention.',
                'icon' => 'stress',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Grief Counseling',
                'slug' => 'grief-counseling',
                'description' => 'Expertise in grief therapy, loss counseling, and bereavement support.',
                'icon' => 'grief',
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Eating Disorders',
                'slug' => 'eating-disorders',
                'description' => 'Specialized in treating eating disorders, body image issues, and related conditions.',
                'icon' => 'eating',
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'LGBTQ+ Counseling',
                'slug' => 'lgbtq-counseling',
                'description' => 'Expertise in LGBTQ+ mental health, identity issues, and coming out support.',
                'icon' => 'lgbtq',
                'is_active' => true,
                'sort_order' => 10,
            ],
        ];

        foreach ($specializations as $specialization) {
            TherapistSpecialization::firstOrCreate(
                ['slug' => $specialization['slug']],
                $specialization
            );
        }
    }
}
