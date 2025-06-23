<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAgreement;

class UserAgreementController extends Controller
{
    // POST /terms/accept
    public function accept()
    {
        $userId = auth()->id();

        $agreement = UserAgreement::updateOrCreate(
            ['user_id' => $userId],
            ['agreed' => true, 'agreed_at' => now()]
        );

        return response()->json(['message' => 'Termos aceitos com sucesso.', 'data' => $agreement]);
    }

    // GET /terms/status
    public function status()
    {
        $agreement = UserAgreement::where('user_id', auth()->id())->first();

        return response()->json([
            'agreed' => $agreement?->agreed ?? false,
            'agreed_at' => $agreement?->agreed_at,
        ]);
    }
}
