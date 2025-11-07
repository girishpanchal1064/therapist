<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Create blog categories
        $categories = [
            [
                'name' => 'Anxiety & Stress',
                'slug' => 'anxiety-stress',
                'description' => 'Articles about managing anxiety and stress',
                'color' => '#EF4444',
                'icon' => 'anxiety',
                'sort_order' => 1,
            ],
            [
                'name' => 'Depression',
                'slug' => 'depression',
                'description' => 'Understanding and coping with depression',
                'color' => '#3B82F6',
                'icon' => 'depression',
                'sort_order' => 2,
            ],
            [
                'name' => 'Relationships',
                'slug' => 'relationships',
                'description' => 'Building healthy relationships and communication',
                'color' => '#10B981',
                'icon' => 'relationships',
                'sort_order' => 3,
            ],
            [
                'name' => 'Self-Care',
                'slug' => 'self-care',
                'description' => 'Tips and strategies for mental wellness',
                'color' => '#F59E0B',
                'icon' => 'self-care',
                'sort_order' => 4,
            ],
            [
                'name' => 'Therapy Tips',
                'slug' => 'therapy-tips',
                'description' => 'Professional insights and therapy guidance',
                'color' => '#8B5CF6',
                'icon' => 'therapy',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $categoryData) {
            BlogCategory::create($categoryData);
        }

        // Get a therapist user to be the author
        $author = User::role('Therapist')->first();
        if (!$author) {
            $therapistRole = \Spatie\Permission\Models\Role::where('name', 'Therapist')->first();
            $author = User::create([
                'name' => 'Dr. Sarah Johnson',
                'email' => 'sarah.johnson@example.com',
                'password' => bcrypt('password'),
                'role_id' => $therapistRole?->id,
            ]);
            $author->assignRole('Therapist');
        }

        // Create blog posts
        $posts = [
            [
                'title' => 'Understanding Anxiety: A Comprehensive Guide',
                'slug' => 'understanding-anxiety-comprehensive-guide',
                'excerpt' => 'Learn about the different types of anxiety, common symptoms, and effective coping strategies to manage anxiety in your daily life.',
                'content' => '<p>Anxiety is a natural human response to stress and danger. However, when anxiety becomes overwhelming and persistent, it can interfere with daily life and well-being.</p><p>There are several types of anxiety disorders, including generalized anxiety disorder, panic disorder, social anxiety disorder, and specific phobias. Each type has its own set of symptoms and treatment approaches.</p><p>Common symptoms of anxiety include excessive worry, restlessness, fatigue, difficulty concentrating, irritability, muscle tension, and sleep disturbances.</p><p>Effective coping strategies include deep breathing exercises, progressive muscle relaxation, mindfulness meditation, regular exercise, maintaining a healthy diet, getting adequate sleep, and seeking professional help when needed.</p>',
                'category_id' => 1,
                'is_featured' => true,
                'published_at' => now()->subDays(2),
                'reading_time' => 5,
            ],
            [
                'title' => '10 Signs You Might Be Experiencing Depression',
                'slug' => '10-signs-you-might-be-experiencing-depression',
                'excerpt' => 'Recognizing the signs of depression is the first step toward getting help. Here are 10 common indicators that you might be experiencing depression.',
                'content' => '<p>Depression is more than just feeling sad or going through a rough patch. It\'s a serious mental health condition that affects how you think, feel, and handle daily activities.</p><p>Some common signs of depression include persistent sadness or emptiness, loss of interest in activities you once enjoyed, changes in appetite or weight, sleep disturbances, fatigue or loss of energy, feelings of worthlessness or guilt, difficulty concentrating, thoughts of death or suicide, physical symptoms like headaches or digestive problems, and social withdrawal.</p><p>If you\'re experiencing several of these symptoms for more than two weeks, it\'s important to seek professional help.</p>',
                'category_id' => 2,
                'is_featured' => false,
                'published_at' => now()->subDays(5),
                'reading_time' => 4,
            ],
            [
                'title' => 'Building Healthy Communication in Relationships',
                'slug' => 'building-healthy-communication-in-relationships',
                'excerpt' => 'Effective communication is the foundation of healthy relationships. Learn practical strategies to improve your communication skills.',
                'content' => '<p>Healthy communication is essential for building and maintaining strong relationships. It involves expressing your thoughts, feelings, and needs clearly while also listening to your partner.</p><p>Key elements of healthy communication include active listening, using "I" statements, being honest and direct, avoiding blame and criticism, showing empathy, and being open to feedback.</p><p>Common communication barriers include assumptions, defensiveness, stonewalling, and poor timing. Learning to recognize and overcome these barriers can significantly improve your relationships.</p>',
                'category_id' => 3,
                'is_featured' => false,
                'published_at' => now()->subDays(7),
                'reading_time' => 6,
            ],
            [
                'title' => 'The Importance of Self-Care for Mental Health',
                'slug' => 'importance-of-self-care-for-mental-health',
                'excerpt' => 'Self-care isn\'t selfish—it\'s essential for maintaining good mental health. Discover practical self-care strategies that work for you.',
                'content' => '<p>Self-care is the practice of taking action to preserve or improve your own health, well-being, and happiness. It\'s not selfish—it\'s necessary for maintaining good mental health.</p><p>Self-care can include physical activities like exercise and proper nutrition, emotional activities like journaling and therapy, social activities like spending time with loved ones, and spiritual activities like meditation or prayer.</p><p>Creating a self-care routine that works for you is important. Start small, be consistent, and don\'t feel guilty about taking time for yourself.</p>',
                'category_id' => 4,
                'is_featured' => false,
                'published_at' => now()->subDays(10),
                'reading_time' => 5,
            ],
            [
                'title' => 'What to Expect in Your First Therapy Session',
                'slug' => 'what-to-expect-in-your-first-therapy-session',
                'excerpt' => 'Feeling nervous about your first therapy session? Here\'s what you can expect and how to prepare for a successful start to your mental health journey.',
                'content' => '<p>Starting therapy can feel intimidating, but knowing what to expect can help ease your anxiety. Your first session is typically an assessment where your therapist will ask questions about your background, current concerns, and goals.</p><p>You\'ll discuss confidentiality, treatment approaches, and what you hope to achieve through therapy. It\'s also an opportunity for you to ask questions and determine if the therapist is a good fit for you.</p><p>Remember that therapy is a collaborative process, and it\'s okay to take time to build trust and rapport with your therapist.</p>',
                'category_id' => 5,
                'is_featured' => false,
                'published_at' => now()->subDays(12),
                'reading_time' => 4,
            ],
            [
                'title' => 'Managing Work Stress: Practical Strategies',
                'slug' => 'managing-work-stress-practical-strategies',
                'excerpt' => 'Work stress is a common issue that can impact your mental health. Learn effective strategies to manage stress in the workplace.',
                'content' => '<p>Work stress is a significant source of mental health challenges for many people. It can lead to burnout, anxiety, depression, and physical health problems.</p><p>Effective strategies for managing work stress include setting boundaries, prioritizing tasks, taking regular breaks, practicing time management, seeking support from colleagues or supervisors, and maintaining work-life balance.</p><p>It\'s also important to recognize when work stress is becoming unmanageable and to seek professional help if needed.</p>',
                'category_id' => 1,
                'is_featured' => false,
                'published_at' => now()->subDays(15),
                'reading_time' => 5,
            ],
            [
                'title' => 'The Science of Mindfulness and Meditation',
                'slug' => 'science-of-mindfulness-and-meditation',
                'excerpt' => 'Discover the scientific benefits of mindfulness and meditation for mental health and learn how to incorporate these practices into your daily life.',
                'content' => '<p>Mindfulness and meditation have been scientifically proven to have numerous benefits for mental health, including reduced anxiety, improved mood, better focus, and increased emotional regulation.</p><p>Mindfulness involves paying attention to the present moment without judgment, while meditation is a formal practice that cultivates mindfulness and other positive mental states.</p><p>You can start with just a few minutes of meditation each day and gradually increase the duration. There are many different types of meditation, so experiment to find what works best for you.</p>',
                'category_id' => 4,
                'is_featured' => false,
                'published_at' => now()->subDays(18),
                'reading_time' => 6,
            ],
            [
                'title' => 'Coping with Grief and Loss',
                'slug' => 'coping-with-grief-and-loss',
                'excerpt' => 'Grief is a natural response to loss, but it can be overwhelming. Learn healthy ways to cope with grief and support others who are grieving.',
                'content' => '<p>Grief is a natural and necessary response to loss, whether it\'s the death of a loved one, the end of a relationship, or other significant life changes.</p><p>The grieving process is unique to each person and doesn\'t follow a linear path. Common emotions include sadness, anger, guilt, and even relief.</p><p>Healthy coping strategies include allowing yourself to feel your emotions, seeking support from others, maintaining routines, taking care of your physical health, and considering professional help if needed.</p>',
                'category_id' => 2,
                'is_featured' => false,
                'published_at' => now()->subDays(20),
                'reading_time' => 5,
            ],
        ];

        foreach ($posts as $postData) {
            $postData['author_id'] = $author->id;
            $postData['status'] = 'published';
            BlogPost::create($postData);
        }
    }
}
