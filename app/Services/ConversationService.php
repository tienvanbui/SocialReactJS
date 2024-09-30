<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\ConversationType;
use App\Http\Resources\UserResource;
use App\Models\Conversation;
use App\Models\User;
use App\Repositories\Conversation\ConversationRepositoryInterface;
use App\Repositories\Participant\ParticipantRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ConversationService
{
    public function __construct(
        private readonly ConversationRepositoryInterface  $conversationRepository,
        private readonly ParticipantRepositoryInterface $participantRepository
    ) {}
    
    public function createFirstTimeConversation(string $creatorID, string $senderID)
    {
        if (empty($this->conversationRepository->checkCreatorInConversation($creatorID, $senderID))) {
            $conversation = $this->conversationRepository->createConversation([
                'creator_id' => $creatorID,
                'type' => ConversationType::PUBLIC
            ]);
            foreach ([$creatorID, $senderID] as $userID) {
                $this->participantRepository->createParticipants([
                    'conversation_id' => $conversation->id,
                    'user_id' => (int)$userID
                ]);
            }
            return $conversation;
        }
    }

    public function getListConversationsOfCurrentUser(string $userID)
    {
        $conversations = $this->conversationRepository->getListConversationByUserId($userID);
        return $conversations->map(function ($conversation): array {
            $user = User::whereId($conversation->user_id)->first();
            $getConversationById = Conversation::with(['messages'])->whereId($conversation->conversation_id)->first();
            $latestMessage = !empty($getConversationById->messages) ? ($getConversationById->messages()->latest()->first()) : [];
            return [
                'user' =>  UserResource::make($user),
                'conversation_id' => $conversation->conversation_id,
                'conversation_created_at' => $conversation->cs_created_at,
                'latest_message' => $latestMessage,
                'friend_user_id' => $conversation->user_id
            ];
        });
    }
}
