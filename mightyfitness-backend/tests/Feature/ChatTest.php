<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_send_and_receive_messages()
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        $this->actingAs($sender, 'sanctum');

        $response = $this->postJson('/api/chat/send', [
            'receiver_id' => $receiver->id,
            'content' => 'Olá!',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('messages', [
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'content' => 'Olá!',
        ]);
    }
}
