<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalNote extends Model
{
    protected $fillable = [
        'personal_id',
        'student_id',
        'note',
        'note_date',
    ];

    public function aluno()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function personal()
    {
        return $this->belongsTo(User::class, 'personal_id');
    }
}
