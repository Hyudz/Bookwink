<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class borrows_table extends Model
{
    use HasFactory;

    protected $table = 'borrows_table';

    protected $fillable = [
        'id',
        'user_id',
        'book_id',
        'borrow_date',
        'return_date',
        'status',
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

    public function notifs()
    {
        return $this->hasMany(notifs_table::class, 'borrow_id', 'id');
    }
}
