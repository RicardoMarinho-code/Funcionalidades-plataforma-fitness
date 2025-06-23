<?php

namespace App\Http\Controllers;

use App\Models\ProgressPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\UserAgreement;

class ProgressPhotoController extends Controller
{
    // 1️ Upload com validação
    public function store(Request $request)
    {
        // ⚠️ Verificar aceite dos termos
    $agreement = UserAgreement::where('user_id', auth()->id())->first();
    if (!$agreement || !$agreement->agreed) {
        return response()->json([
            'message' => 'Você precisa aceitar os termos de uso antes de enviar fotos.'
        ], 403);
    }

        $request->validate([
            'photo_date' => 'required|date',
            'weight' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'pose' => 'nullable|in:frente,perfil,costas',
            'privacy' => 'nullable|in:privado,personal,publico',
            'image' => 'required|image|max:5120',
        ]);

        $path = $request->file('image')->store('progress_photos', 'public');

        $photo = ProgressPhoto::create([
            'user_id' => auth()->id(),
            'photo_date' => $request->photo_date,
            'weight' => $request->weight,
            'notes' => $request->notes,
            'pose' => 'nullable|in:frente,perfil,costas,3_4,sentado',
            'privacy' => $request->privacy ?? 'privado',
            'image_path' => $path,
        ]);

        return response()->json(['message' => 'Foto salva com sucesso.', 'data' => $photo], 201);
    }

    // 2️⃣ Listagem com filtro por data (e respeitando privacidade)
    public function index(Request $request)
    {
        $query = ProgressPhoto::query();

        // Se for aluno: vê só as suas
        if (auth()->user()->tipo == 'aluno') {
            $query->where('user_id', auth()->id());
        }

        // Se for personal: vê fotos públicas ou marcadas como visível para personal
        if (auth()->user()->tipo == 'personal') {
            if ($request->has('aluno_id')) {
                $query->where('user_id', $request->aluno_id)
                      ->whereIn('privacy', ['publico', 'personal']);
            } else {
                return response()->json(['erro' => 'aluno_id obrigatório'], 422);
            }
        }

        // Filtro por período
        if ($request->has('inicio') && $request->has('fim')) {
            $query->whereBetween('photo_date', [$request->inicio, $request->fim]);
        }

        $photos = $query->orderBy('photo_date', 'asc')->get();

        return response()->json($photos);
    }

    // 3️⃣ Visualização em pares (antes e depois)
    public function pairedView(Request $request)
    {
        $photos = ProgressPhoto::where('user_id', auth()->id())
            ->orderBy('photo_date')
            ->get();

        $pairs = [];

        for ($i = 0; $i < count($photos) - 1; $i++) {
            $pairs[] = [
                'antes' => $photos[$i],
                'depois' => $photos[$i + 1],
            ];
        }

        return response()->json($pairs);
    }
}
