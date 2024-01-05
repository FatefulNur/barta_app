<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Constants\MediaCollectionName;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, HasUuids, InteractsWithMedia, Notifiable;

    const DEFAULT_IMAGE_PATH = '/images/avatar-default.png';

    protected $fillable = [
        'name',
        'username',
        'email',
        'bio',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getProfileImage()
    {
        return $this->getFirstMediaUrl(MediaCollectionName::PROFILE_IMAGE);
    }

    public function isAuthor(): bool
    {
        return auth()->id() === $this->id;
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function firstName(): string
    {
        return str()->of($this->name)->before(' ')->title();
    }

    public function fullName(): string
    {
        return str()->of($this->name)->title();
    }

    public function bio(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value ?? 'Less Talk, More Code 💻',
        );
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(MediaCollectionName::PROFILE_IMAGE)
            ->singleFile()
            ->useDisk('avatar')
            ->useFallbackUrl(self::DEFAULT_IMAGE_PATH);
    }
}
