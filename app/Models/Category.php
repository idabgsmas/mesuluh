<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'text_color',
        'bg_color',
        'description',
    ];
    
    // Relasi: Satu Kategori memiliki BANYAK Post
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
