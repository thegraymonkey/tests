<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Publisher extends Model
{
    public const EMAIL = 'email';

    public const APPROVED = 'approved';

    protected $fillable = [
        'email',
        'approved',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
