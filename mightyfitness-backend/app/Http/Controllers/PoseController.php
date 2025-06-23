<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PoseController extends Controller
{
    public function index()
    {
        return response()->json([
            ['id' => 'frente', 'nome' => 'Frente'],
            ['id' => 'perfil', 'nome' => 'Perfil'],
            ['id' => 'costas', 'nome' => 'Costas'],
            ['id' => '3_4', 'nome' => '¾ (diagonal)'],
            ['id' => 'sentado', 'nome' => 'Sentado'],
        ]);
    }
}
