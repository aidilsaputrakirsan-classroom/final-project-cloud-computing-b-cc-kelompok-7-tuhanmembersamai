<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'avatar',
    ];

    protected $hidden = ['password'];

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function responses() {
        return $this->hasMany(HistoryRespon::class);
    }
}

