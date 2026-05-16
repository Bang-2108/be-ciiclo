<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\Social; 

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profile = Profile::updateOrCreate(
            ['id' => 1], 
            [
                'name' => 'Zoan Thi Bang',
                'role' => 'Full Stack Developer',
                'bio'  => 'I am a final-year Software Engineering student. Currently, I focus on building high-quality web applications with modern frameworks.',
                'education' => 'Software Engineering - Passerelles Numériques Vietnam',
                'objective' => 'Becoming a professional Senior Developer.',
                'avatar'    => 'http://127.0.0.1:9000/ciiclo-storage/hero/b5.jpg',
                'is_available' => true,
                'stats_experience'  => 1,
                'stats_projects'    => 5,
                'stats_internships' => 1,
            ]
        );
        $profile->socials()->delete();
        
        $profile->socials()->createMany([
            [
                'platform' => 'Github',
                'icon'     => 'bi-github',
                'url'      => 'https://github.com/zoanthibang',
                'sort_order' => 1
            ],
            [
                'platform' => 'LinkedIn',
                'icon'     => 'bi-linkedin',
                'url'      => 'https://linkedin.com/in/zoanthibang',
                'sort_order' => 2
            ]
        ]);
    }
}