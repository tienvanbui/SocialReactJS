<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface  $userRepository,
    ) {}


    public function addAsFriend(int $personID)
    {
        $currentUser = Auth::user();

        $currentUser->friends()->create([
            'friend_id' => $personID
        ]);

        $opUser = User::whereId($personID)->first();

        if (!empty($opUser)) {
            $opUser->friends()->create([
                'friend_id' => $currentUser->id
            ]);
        }
    }
}
