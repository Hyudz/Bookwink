<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users_table extends Model
{
    use HasFactory;

    protected $table = 'users_table';

    protected $fillable = [
        'id',
        'username',
        'email',
        'password',
        'age',
        'birthday',
        'gender',
        'address',
        'user_type',
        'created_at',
        'updated_at'
    ];
}
