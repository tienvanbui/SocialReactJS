<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $table = "participants";

    protected $fillable = [
        'conversation_id',
        'user_id',
        'pinned_at'
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class , 'conversation_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }
}
