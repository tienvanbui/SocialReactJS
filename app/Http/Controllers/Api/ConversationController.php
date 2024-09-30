<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateConversationRequest;
use App\Models\User;
use App\Services\ConversationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    protected $conversationService;

    public function __construct(ConversationService $conversationService)
    {
        $this->conversationService = $conversationService;
    }

    public function store(CreateConversationRequest $request)
    {
        $currentUser = Auth::user();
        $personID = $request->person_id;
        $conversation = $this->conversationService->createFirstTimeConversation((string)$currentUser->id, (string)$personID);
        return $this->sendCreatedSuccessResponse($conversation);
    }
}
