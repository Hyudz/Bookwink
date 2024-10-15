<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notifs_table extends Model
{
    use HasFactory;

    protected $table = 'notifs_tables';

    protected $fillable = [
        'id',
        'user_id',
        'borrow_id',
        'notification_type',
        'message',
        'is_read',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(users_table::class, 'user_id', 'id');
    }

    public function borrow()
    {
        return $this->belongsTo(borrows_table::class, 'borrow_id', 'id');
    }
}
