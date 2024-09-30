<?php

declare(strict_types=1);

namespace App\Repositories\Conversation;

use App\Enums\ConversationType;
use App\Models\Conversation;
use App\Models\User;
use App\Repositories\Conversation\ConversationRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConversationRepository implements ConversationRepositoryInterface
{
    public function __construct(private readonly Conversation $model) {}

    public function createConversation(array $data)
    {
        return $this->model::create($data);
    }

    public function checkCreatorInConversation(string $currentUserID, string $personID, int $type = ConversationType::PUBLIC)
    {
        $conversation  = $this->model::from('conversations as cs')
            ->join("participants as p1", function ($join) use ($currentUserID) {
                $join->on('p1.conversation_id', '=', 'cs.id')
                    ->where('p1.user_id', $currentUserID);
            })
            ->join("participants as p2", function ($join) use ($personID) {
                $join->on("p2.conversation_id", '=', 'cs.id')
                    ->where('p2.user_id', $personID);
            })
            ->join(
                DB::raw('(SELECT conversation_id FROM participants GROUP BY conversation_id HAVING COUNT(conversation_id) = 2) as valid_conversations'),
                'cs.id',
                '=',
                'valid_conversations.conversation_id'
            )
            ->where('type', $type)
            ->get();
        if ($conversation->count() > 0) {
            return $conversation[0];
        }
        return [];
    }

    public function getConversationByCreatorID(string $creatorID)
    {
        return $this->model::where('creator_id', $creatorID)->first();
    }

    public function getListConversationByUserId(string $userID)
    {
        $conversations = $this->model::from('conversations as cs')
            ->select('cs.created_at as cs_created_at', 'p.*')
            ->join('participants as p', function ($join) use ($userID) {
                $join->on('p.conversation_id', '=', 'cs.id')
                    ->where('user_id', '!=', $userID);
            })
            ->where('creator_id', $userID)
            ->latest()
            ->paginate(config('const.pagination'));
        return $conversations;
    }
}
