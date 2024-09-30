<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Repositories\Conversation\ConversationRepository;
use App\Repositories\Message\MessageRepository;
use App\Services\ConversationService;
use App\Services\ParticipantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    protected $conversationService;
    protected $participantService;

    public function __construct(ConversationService $conversationService, ParticipantService $participantService)
    {
        $this->conversationService = $conversationService;
        $this->participantService = $participantService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUserID = Auth::user()->id;
        return $this->conversationService->getListConversationsOfCurrentUser((string)$currentUserID);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function pinParticipant(int $conversationID, int $personID)
    {
        try {
            $this->participantService->pinTheParticipant($conversationID, $personID);
            return $this->sendCreatedSuccessResponse();
        } catch (\Exception $e) {
            return $this->sendServerErrorResponse();
        }
    }

    public function unpinParticipant(int $conversationID, int $personID)
    {
        try {
            $this->participantService->unpinTheParticipant($conversationID, $personID);
            return $this->sendCreatedSuccessResponse();
        } catch (\Exception $e) {
            return $this->sendServerErrorResponse();
        }
    }
}
