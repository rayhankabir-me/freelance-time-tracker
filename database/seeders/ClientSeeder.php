<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        Client::insert([
            [
                'user_id' => 1,
                'name' => 'Dummy Company',
                'email' => 'dummycompany@example.com',
                'contact_person' => 'Alice Johnson',
            ],
            [
                'user_id' => 1,
                'name' => 'Globex Inc.',
                'email' => 'globexinc@example.com',
                'contact_person' => 'Bob Smith',
            ],
        ]);
    }
}
