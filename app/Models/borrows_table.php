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
}
