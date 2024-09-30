<?php

declare(strict_types=1);

namespace App\Repositories\Participant;

interface ParticipantRepositoryInterface
{
    public function createParticipants(array $data);
    public function checkUserIsInConversation(string $userID, string $conversationID);
    public function pinParticipant(int $conversationID , int $userID);
    public function unPinParticipant(int $conversationID, int $userID);
}
