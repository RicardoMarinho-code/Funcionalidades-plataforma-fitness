<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProgressPhotoTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_progress_photo()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        // Simula aceite dos termos
        $user->userAgreement()->create(['agreed' => true, 'agreed_at' => now()]);

        $response = $this->postJson('/api/progress-photos', [
            'photo_date' => now()->toDateString(),
            'weight' => 70,
            'notes' => 'Primeira foto',
            'pose' => 'frente',
            'privacy' => 'privado',
            'image' => UploadedFile::fake()->image('progresso.jpg'),
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('progress_photos', [
            'user_id' => $user->id,
            'weight' => 70,
            'pose' => 'frente',
        ]);
    }
}