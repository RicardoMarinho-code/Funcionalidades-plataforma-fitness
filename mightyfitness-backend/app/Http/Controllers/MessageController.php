<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    // Listar todas as mensagens entre dois usuários
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $messages = Message::where(function ($query) use ($request) {
            $query->where('sender_id', $request->sender_id)
                  ->where('receiver_id', $request->receiver_id);
        })->orWhere(function ($query) use ($request) {
            $query->where('sender_id', $request->receiver_id)
                  ->where('receiver_id', $request->sender_id);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json($messages);
    }

    // Enviar uma nova mensagem
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sender_id'   => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
            'content'     => 'required|string',
            'type'        => 'in:text,image'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $message = Message::create([
            'sender_id'   => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'content'     => $request->content,
            'type'        => $request->type ?? 'text',
        ]);

        return response()->json($message, 201);
    }
}
