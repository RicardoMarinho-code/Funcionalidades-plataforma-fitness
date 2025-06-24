<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgressPhotoController;
use App\Http\Controllers\UserAgreementController;
use App\Http\Controllers\PersonalNoteController;
use App\Http\Controllers\PoseController;
use App\Http\Controllers\ChatController as AuthChatController;

Route::post('/progress-photos', [ProgressPhotoController::class, 'store']);
Route::get('/progress-photos', [ProgressPhotoController::class, 'index']);
Route::get('/progress-photos/pares', [ProgressPhotoController::class, 'pairedView']);
Route::post('/terms/accept', [UserAgreementController::class, 'accept']);
Route::get('/terms/status', [UserAgreementController::class, 'status']);
Route::post('/notes', [PersonalNoteController::class, 'store']);
Route::get('/notes/{student_id}', [PersonalNoteController::class, 'index']);
Route::get('/poses', [PoseController::class, 'index']);
Route::get('/progress-photos/pares', [ProgressPhotoController::class, 'pairedView']);
Route::post('/chat/send', [AuthChatController::class, 'sendMessage']);
Route::get('/chat/{userId}', [AuthChatController::class, 'getMessages']);
