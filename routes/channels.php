<?php

use App\Models\Conversation;
use App\Models\MyFriend;
use App\Models\Participant;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('conversation_private_{id}', function ($user, $id) {

    $conversation = Conversation::whereId($id)->first();

    if (!empty($conversation)) {
        $participants = Participant::where('conversation_id', $conversation->id)
            ->pluck('user_id')
            ->toArray();
        if (in_array($user->id, $participants)) {
            $checkIsFriend  = MyFriend::where(function ($q) use ($participants) {
                $q->where('friend_id', $participants[0])
                    ->where('user_id', $participants[1]);
            })
                ->orWhere(function ($q) use ($participants) {
                    $q->where('user_id', $participants[0])
                        ->where('friend_id', $participants[1]);
                })
                ->get();
            if (!empty($checkIsFriend)) {
                return ['id' => $user->id, 'name' => $user->name];
            }
            return false;
        }
    }
    return false;
});
