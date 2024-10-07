<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rrs_table extends Model
{
    use HasFactory;

    protected $table = 'rrs_tables';

    protected $fillable = [
        'id',
        'user_id',
        'book_id',
        'rating',
        'review',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(users_table::class, 'user_id', 'id');
    }

    public function book()
    {
        return $this->belongsTo(books_table::class, 'book_id', 'id');
    }

    
}
