<?php

namespace App\Http\Controllers;

use App\Events\sentNewMessage;
use App\Http\Requests\CreateMessageRequest;
use App\Services\MessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $conversation_id = $request->conversation_id;
        return $this->messageService->getListMessageByConversationID($conversation_id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateMessageRequest $request)
    {
        $data = $request->validated();
        try {
            $data = array_merge($data, [
                'sender_id' => Auth::user()->id
            ]);
            $message = $this->messageService->createNewMessage($data);
            broadcast(new sentNewMessage($message->conversation_id));
            return $this->sendCreatedSuccessResponse($message);
        } catch (\Exception $e) {
            return $this->sendServerErrorResponse();
        }
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
}
