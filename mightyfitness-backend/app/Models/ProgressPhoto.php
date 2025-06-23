<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image_path',
        'photo_date',
        'weight',
        'notes',
        'pose',
        'privacy',
    ];

    // Relacionamento: uma foto pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
