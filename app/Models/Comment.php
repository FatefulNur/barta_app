<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'body',
        'user_id',
        'post_id',
    ];

    /**
     * BelongsTo relations for comment user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
