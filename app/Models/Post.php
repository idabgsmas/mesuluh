<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Penting: Import ini

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'status_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'revision_notes',
        'thumbnail',
        'published_at',
        'is_featured',
        'views',
        'seo_title',
        'seo_description',
        'seo_image',
        'notification_sent',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'views' => 'integer',
        'notification_sent' => 'boolean',
    ];

    // --- DEFINISI RELASI (INI YANG TADI KURANG) ---

    // 1. Relasi: Post dimiliki oleh User (Penulis)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // 2. Relasi: Post masuk dalam satu Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // 3. Relasi: Post memiliki satu Status
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    // 4. Relasi ke Tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // 5. Relasi ke PostViews
    public function views(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PostView::class);
    }
}