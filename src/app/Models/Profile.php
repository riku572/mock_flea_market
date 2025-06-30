<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'image_path',
        'postal_code',
        'address',
        'building_name',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

