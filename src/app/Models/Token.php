<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'token',
        'expires_at'
    ];

    protected $dates = ['deleted_at'];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
