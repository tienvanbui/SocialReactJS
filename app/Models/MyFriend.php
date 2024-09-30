<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyFriend extends Model
{
    use HasFactory;

    protected $table = 'my_friends';
    
    protected $fillable = [
        'user_id',
        'is_block',
        'friend_id'
    ];
    
}
