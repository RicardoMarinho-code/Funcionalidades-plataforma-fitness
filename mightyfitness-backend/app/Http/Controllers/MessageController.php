<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\NewMessageEvent;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
            'image_path' => $request->file('image')?->store('chat_images', 'public'),
        ]);

        broadcast(new NewMessageEvent($message))->toOthers();

        return response()->json($message);
    }

    public function fetchMessages($withUserId)
    {
        $messages = Message::where(function ($q) use ($withUserId) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $withUserId);
        })->orWhere(function ($q) use ($withUserId) {
            $q->where('sender_id', $withUserId)->where('receiver_id', Auth::id());
        })->orderBy('created_at')->get();

        return response()->json($messages);
    }
}
