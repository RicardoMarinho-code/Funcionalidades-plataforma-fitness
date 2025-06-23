<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAgreement extends Model
{
    protected $fillable = ['user_id', 'agreed', 'agreed_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}