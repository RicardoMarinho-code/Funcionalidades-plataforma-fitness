<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalNote;

class PersonalNoteController extends Controller
{
    // Salvar nota privada
    public function store(Request $request)
    {
        if (auth()->user()->tipo !== 'personal') {
            return response()->json(['erro' => 'Apenas personais podem criar notas'], 403);
        }

        $request->validate([
            'student_id' => 'required|exists:users,id',
            'note' => 'required|string',
            'note_date' => 'nullable|date',
        ]);

        $note = PersonalNote::create([
            'personal_id' => auth()->id(),
            'student_id' => $request->student_id,
            'note' => $request->note,
            'note_date' => $request->note_date ?? now(),
        ]);

        return response()->json(['mensagem' => 'Nota salva com sucesso.', 'nota' => $note]);
    }

    // Listar notas por aluno
    public function index(Request $request, $student_id)
    {
        if (auth()->user()->tipo !== 'personal') {
            return response()->json(['erro' => 'Apenas personais podem visualizar notas'], 403);
        }

        $query = PersonalNote::where('personal_id', auth()->id())
                             ->where('student_id', $student_id);

        if ($request->filled('inicio') && $request->filled('fim')) {
            $query->whereBetween('note_date', [$request->inicio, $request->fim]);
        }

        $notas = $query->orderBy('note_date', 'desc')->get();

        return response()->json($notas);
    }
}
