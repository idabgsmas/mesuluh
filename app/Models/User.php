<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Post;
use App\Models\Role;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username', // Tambahan
        'email',
        'password',
        'role_id', // Tambahan
        'bio',     // Tambahan
        'avatar',  // Tambahan
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi: User memiliki BANYAK Post
     */
    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Relasi: User dimiliki oleh satu Role
     */
    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Ini kuncinya!
     * Memberitahu Laravel untuk menggunakan kolom 'username' saat membuat link route.
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    // Cek apakah Admin
    public function isAdmin(): bool
    {
        return $this->role_id === 1;
    }

    // Cek apakah Editor
    public function isEditor(): bool
    {
        return $this->role_id === 2;
    }

    // Cek apakah Penulis
    public function isPenulis(): bool
    {
        return $this->role_id === 3;
    }
}
