<?php

namespace App\Models;

use App\Constants\MediaCollectionName;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use HasFactory, HasUuids, InteractsWithMedia;

    protected $fillable = [
        'body',
        'user_id',
        'view_count',
    ];

    public function getPostImage()
    {
        return $this->getFirstMediaUrl(MediaCollectionName::POST_IMAGE);
    }

    /**
     * BelongsTo relations for post user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(MediaCollectionName::POST_IMAGE)
            ->singleFile()
            ->useDisk('media');
    }
}
