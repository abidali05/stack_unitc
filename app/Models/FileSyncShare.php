<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSyncShare extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function file()
    {
        return $this->belongsTo(FileSync::class, 'file_id');
    }

    public function sharedWith()
    {
        return $this->belongsTo(User::class, 'share_with_user_id');
    }

    public function sharedBy()
    {
        return $this->belongsTo(User::class, 'share_by_user_id');
    }
}
