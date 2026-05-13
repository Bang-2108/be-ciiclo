<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Zoan Thi Bang',
            'email' => 'zoanthibang@gmail.com',
            'password' => Hash::make('bang1234'),
        ]);
    }
}
