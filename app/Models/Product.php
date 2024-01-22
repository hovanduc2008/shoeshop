<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;




class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'added_by',
        'title',
        'slug',
        'image',
        'thumbnail',
        'price',
        'quantity',
        'category_id',
        'description',
        'content',
        'meta_title',
        'meta_description',
        'deleted_at',
        'status'
    ];

}
