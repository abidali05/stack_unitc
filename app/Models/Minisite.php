<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Minisite extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'page_added_by');
    }
}
