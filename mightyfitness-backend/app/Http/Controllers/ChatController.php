<?php

namespace App\Http\Controllers;

use App\Events\NewMessageEvent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $data = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $data['sender_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('chat_images', 'public');
        }

        $message = Message::create($data);

        broadcast(new NewMessageEvent($message))->toOthers();

        return response()->json($message, 201);
    }

    public function getMessages($userId)
    {
        $user = auth()->user();

        $messages = Message::where(function ($q) use ($userId, $user) {
            $q->where('sender_id', $user->id)
              ->where('receiver_id', $userId);
        })->orWhere(function ($q) use ($userId, $user) {
            $q->where('sender_id', $userId)
              ->where('receiver_id', $user->id);
        })->orderBy('created_at')->get();

        return response()->json($messages);
    }
}
