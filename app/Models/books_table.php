<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class books_table extends Model
{
    use HasFactory;

    protected $table = 'books_table';

    protected $fillable = [
        'id',
        'title',
        'author',
        'category',
        'description',
        'status',
        'cover',
        'rating',
        'created_at',
        'updated_at'
    ];
}
