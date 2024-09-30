<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Message\MessageRepositoryInterface;

class MessageService
{
    public function __construct(private readonly MessageRepositoryInterface $messageRepository) {}

    public function createNewMessage(array $data)
    {
        return $this->messageRepository->createMessage($data);
    }

    public function getListMessageByConversationID(int $conversationID) 
    {
        return $this->messageRepository->getListMessage($conversationID);
    }
}
