<?php

declare(strict_types=1);

namespace App\Repositories\Message;

use App\Models\Message;
use App\Repositories\Message\MessageRepositoryInterface;

class MessageRepository implements MessageRepositoryInterface
{
    public function __construct(private readonly Message $model) {}

    public function createMessage(array $data)
    {
        return $this->model::create($data);
    }

    public function getListMessage(int $conversationID)
    {
        return $this->model::where('conversation_id', $conversationID)
            ->orderBy('created_at', 'asc')
            ->paginate(config('const.pagination'));
    }
}
