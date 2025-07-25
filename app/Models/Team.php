<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function users() {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id');
    }
}
