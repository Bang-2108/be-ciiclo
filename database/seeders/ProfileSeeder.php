<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\ProfileSocial;
use App\Models\ProfileBadge;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profile = Profile::create([
            'name' => 'Zoan Thi Bang',

            'role' => 'Full Stack Developer',

            'description' =>
                'I am a final-year Software Engineering student. Currently, I focus on building high-quality web applications with modern frameworks.',

            'avatar' =>
                'http://127.0.0.1:9000/ciiclo-storage/hero/b5.jpg'
        ]);

        ProfileSocial::insert([
            [
                'profile_id' => $profile->id,

                'platform' => 'Github',

                'icon' => 'bi-github',

                'url' => '#'
            ],
            [
                'profile_id' => $profile->id,

                'platform' => 'LinkedIn',

                'icon' => 'bi-linkedin',

                'url' => '#'
            ]
        ]);

        ProfileBadge::insert([
            [
                'profile_id' => $profile->id,

                'label' => 'Design',

                'icon' => 'bi-palette',

                'position' => 'design'
            ],
            [
                'profile_id' => $profile->id,

                'label' => 'Code',

                'icon' => 'bi-code-slash',

                'position' => 'code'
            ]
        ]);
    }
}
