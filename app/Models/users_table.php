<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users_table extends Model
{
    use HasFactory;

    protected $table = 'users_tables';

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
        'phone_number',
        'created_at',
        'updated_at'
    ];

    public function borrows()
    {
        return $this->hasMany(borrows_table::class, 'user_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(rrs_table::class, 'user_id', 'id');
    }

    public function notifs()
    {
        return $this->hasMany(notifs_table::class, 'user_id', 'id');
    }

    public function bookmarks()
    {
        return $this->hasMany(bookmarks::class, 'user_id', 'id');
    }
}
