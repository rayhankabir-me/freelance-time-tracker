<?php

// app/Models/TimeLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    use HasFactory;

    protected $table = "time_logs";
    protected $fillable = [
        'project_id',
        'start_time',
        'end_time',
        'description',
        'hours',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

