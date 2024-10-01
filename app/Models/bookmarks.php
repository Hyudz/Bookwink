<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bookmarks extends Model
{
    use HasFactory;

    protected $table = 'bookmarks';

    protected $fillable = [
        'id',
        'user_id',
        'book_id',
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
