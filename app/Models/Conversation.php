<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $table = "conversations";

    protected $fillable = [
        'name',
        'type',
        'creator_id'
    ];

    public function participants()
    {
        return $this->hasMany(Participant::class, 'conversation_id');
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'creator_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, Participant::class, 'conversation_id', 'user_id')->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id');
    }
}
