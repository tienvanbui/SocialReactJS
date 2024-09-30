<?php

declare(strict_types=1);

namespace App\Repositories\Participant;

use App\Models\Participant;
use App\Repositories\Participant\ParticipantRepositoryInterface;
use Carbon\Carbon;

class ParticipantRepository implements ParticipantRepositoryInterface
{
    public function __construct(private readonly Participant $model) {}
    public function createParticipants(array $data)
    {
        return $this->model::create($data);
    }

    public function checkUserIsInConversation(string $userID, string $conversationID)
    {
        $getParticipantByConversationId = $this->model::where('conversation_id', $conversationID)->where('user_id', $userID)->first();
        if (!empty($getParticipantByConversationId)) {
            return true;
        }
        return false;
    }

    public function pinParticipant(int $conversationID, int $userID)
    {
        $this->model::where('conversation_id', $conversationID)
            ->where('user_id', $userID)
            ->update([
                'pinned_at' => Carbon::now()
            ]);
    }

    public function unPinParticipant(int $conversationID, int $userID)
    {
        $this->model::where('conversation_id', $conversationID)
            ->where('user_id', $userID)
            ->update([
                'pinned_at' => NULL
            ]);
    }
}
