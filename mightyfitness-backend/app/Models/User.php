<?php

namespace App\Models;

use App\Models\ProgressPhoto;
use App\Models\PersonalNote;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'tipo' => 'string',
    ];

    /**
     * Relacionamento: um usuário pode ter muitas fotos de progresso.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function progressPhotos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProgressPhoto::class);
    }

    /**
     * Se for personal, ele pode ter anotações feitas para os alunos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notasComoPersonal(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PersonalNote::class, 'personal_id');
    }

    /**
     * Se for aluno, ele pode ter notas associadas a ele.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notasRecebidas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PersonalNote::class, 'student_id');
    }

    /**
     * Sempre criptografa a senha antes de salvar.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
