<?php

use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/create-conversation', [ConversationController::class, 'store']);
Route::apiResource('message', MessageController::class);
Route::apiResource('chat', ChatController::class);
Route::post('/participant-pin', [ChatController::class, 'pinParticipant']);
Route::post('/participant-unpin', [ChatController::class, 'unpinParticipant']);
