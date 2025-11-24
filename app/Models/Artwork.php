<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    use HasFactory;

    protected $table = 'artworks';

    protected $fillable = [
        'user_id',
        'category_id',
        'image',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);   // FK: user_id
    }

    public function category()
    {
        return $this->belongsTo(Category::class); // FK: category_id
    }

    public function comments()
    {
        // 👉 penting: FK di tabel comments = artwork_id
        return $this->hasMany(Comment::class, 'artwork_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

}
