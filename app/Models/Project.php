<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $table = "projects";
    protected $fillable = [
        'client_id',
        'title',
        'description',
        'status',
        'deadline',
    ];

    protected function casts(): array
    {
        return [
            'id'            => 'integer',
            'client_id'     => 'integer',
            'title'         => 'string',
            'description'   => 'string',
            'status'        => 'string',
            'deadline'      => 'string',
        ];
    }

    // Relationships
    public function client() : BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function timeLogs() : HasMany
    {
        return $this->hasMany(TimeLog::class);
    }
}

