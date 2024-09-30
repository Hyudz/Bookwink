<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notifs_table extends Model
{
    use HasFactory;

    protected $table = 'notifs_table';

    protected $fillable = [
        'id',
        'user_id',
        'notification_type',
        'message',
        'is_read',
        'created_at',
        'updated_at'
    ];
}
