<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Participant\ParticipantRepositoryInterface;

class ParticipantService
{
    public function __construct(private readonly ParticipantRepositoryInterface $participantRepository) {}

    public function pinTheParticipant(int $conversationID , int $userID)
    {
        $this->participantRepository->pinParticipant($conversationID , $userID);
    }

    public function unpinTheParticipant(int $conversationID , int $userID)
    {
        $this->participantRepository->unPinParticipant($conversationID, $userID);
    }
}
