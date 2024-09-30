<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class AddFriendController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(Request $request)
    {
        try {
            $this->userService->addAsFriend($request->person_id);
            return $this->sendCreatedSuccessResponse();
        } catch (\Exception $e) {
            return $this->sendServerErrorResponse();
        }
    }
}
