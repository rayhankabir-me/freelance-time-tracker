<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $table = "clients";
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'contact_person',
    ];

    protected function casts(): array
    {
        return [
            'id'                 => 'integer',
            'user_id'            => 'integer',
            'name'               => 'string',
            'email'              => 'string',
            'contact_person'     => 'string',
        ];
    }
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function projects() : HasMany
    {
        return $this->hasMany(Project::class);
    }
}
