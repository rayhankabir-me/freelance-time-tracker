<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::insert([
            [
                'client_id' => 1,
                'title' => 'Website Redesign',
                'description' => 'Redesign corporate website using Laravel + Vue.',
                'status' => Status::ACTIVE,
                'deadline' => Carbon::now()->addDays(15),
            ],
            [
                'client_id' => 2,
                'title' => 'Mobile App Development',
                'description' => 'Build a cross-platform mobile app for sales team.',
                'status' => Status::COMPLETED,
                'deadline' => Carbon::now()->subDays(5),
            ],
        ]);
    }
}
