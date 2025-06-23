<?php
use App\Http\Controllers\ChatController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
    Route::get('/chat/{userId}', [ChatController::class, 'getMessages']);
});
