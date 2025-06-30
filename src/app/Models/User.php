<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;  //認証メール自動送信
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likedProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'likes', 'user_id', 'product_id');
    }

    public function purchasedProducts()
    {
        return $this->belongsToMany(Product::class, 'purchases', 'user_id', 'product_id')->withTimestamps();
    }
}
