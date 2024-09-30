<?php

declare(strict_types=1);

namespace App\Repositories\Message;

interface MessageRepositoryInterface
{
    public function createMessage(array $data);
    public function getListMessage(int $conversationID);
}