<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsFeed extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'source',
        'description',
        'urlToImage',
        'url',
        'user_id',
        'publishedAt',
    ];
}
