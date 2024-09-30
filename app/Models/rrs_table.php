<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rrs_table extends Model
{
    use HasFactory;

    protected $table = 'rrs_table';

    protected $fillable = [
        'id',
        'user_id',
        'book_id',
        'rating',
        'review',
        'created_at',
        'updated_at'
    ];
}
