<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class books_table extends Model
{
    use HasFactory;

    protected $table = 'books_tables';

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

    public function borrows()
    {
        return $this->hasMany(borrows_table::class, 'book_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(rrs_table::class, 'book_id', 'id');
    }

    public function bookmarks()
    {
        return $this->hasMany(bookmarks::class, 'book_id', 'id');
    }
}
