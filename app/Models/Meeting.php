<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'google_event_id',
        'topic',
        'start_time',
        'duration',
        'agenda',
        'meeting_url',
        'cancelled_at'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'meeting_user');
    }
}
