<?php

declare(strict_types=1);

namespace App\Repositories\Conversation;

use Illuminate\Support\Collection;

interface ConversationRepositoryInterface
{
    public function createConversation(array $data);
    public function checkCreatorInConversation(string $currentUserID , string $personID);
    public function getConversationByCreatorID(string $creatorID);
    public function getListConversationByUserId(string $userID);
}
