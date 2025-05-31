<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'id'       => 1,
                'name'     => 'Rayhan Kabir',
                'email'    => 'rayhankabir@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
            ],
            [
                'id'       => 2,
                'name'     => 'John Doe',
                'email'    => 'johndoe@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
            ],
            [
                'id'       => 3,
                'name'     => 'Jane Doe',
                'email'    => 'janedoe@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
            ],
            [
                'id'       => 4,
                'name'     => 'Ashikur Rahman',
                'email'    => 'ashikurrahman@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
