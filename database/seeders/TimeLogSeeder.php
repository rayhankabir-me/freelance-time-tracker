<?php

namespace Database\Seeders;

use App\Models\TimeLog;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TimeLogSeeder extends Seeder
{
    public function run(): void
    {
        TimeLog::insert([
            [
                'project_id' => 1,
                'start_time' => Carbon::parse('2025-04-01 09:00:00'),
                'end_time' => Carbon::parse('2025-04-01 12:00:00'),
                'description' => 'Initial design discussion and wireframing.',
                'hours' => 3.0,
            ],
            [
                'project_id' => 1,
                'start_time' => Carbon::parse('2025-04-02 10:00:00'),
                'end_time' => Carbon::parse('2025-04-02 14:30:00'),
                'description' => 'Frontend development (landing page).',
                'hours' => 4.5,
            ],
            [
                'project_id' => 2,
                'start_time' => Carbon::parse('2025-03-20 09:30:00'),
                'end_time' => Carbon::parse('2025-03-20 11:00:00'),
                'description' => 'App UI layout and navigation setup.',
                'hours' => 1.5,
            ],
            [
                'project_id' => 2,
                'start_time' => Carbon::parse('2025-03-21 12:00:00'),
                'end_time' => Carbon::parse('2025-03-21 15:00:00'),
                'description' => 'API integration with backend.',
                'hours' => 3.0,
            ],
            [
                'project_id' => 1,
                'start_time' => Carbon::parse('2025-04-03 09:00:00'),
                'end_time' => Carbon::parse('2025-04-03 11:30:00'),
                'description' => 'Responsive adjustments and bug fixes.',
                'hours' => 2.5,
            ],
        ]);
    }
}
