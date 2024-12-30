<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    public const PUBLISHER_ID = 'publisher_id';

    public const TITLE = 'title';

    public const DESCRIPTION = 'description';

    protected $fillable = [
        'publisher_id',
        'title',
        'description',
    ];

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }
}
