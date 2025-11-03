<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryRespon extends Model
{
    use HasFactory;

    protected $table = 'history_respon';

    protected $fillable = [
        'post_id',
        'user_id',
        'response',
        'likes_count',
        'parent_id',
    ];

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function parent() {
        return $this->belongsTo(HistoryRespon::class, 'parent_id');
    }

    public function replies() {
        return $this->hasMany(HistoryRespon::class, 'parent_id');
    }
}

