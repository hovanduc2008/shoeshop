<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'added_by',
        'title',
        'slug',
        'image',
        'thumbnail',
        'status',
        'content',
        'meta_title',
        'description',
        'meta_description',
        'deleted_at'
    ];
}
