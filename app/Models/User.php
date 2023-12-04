<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use App\Enums\MediaCollectionEnum;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'bio',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * HasMany relations for user posts
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function firstName(): string
    {
        return str()->of($this->name)->before(' ');
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
            ->addMediaCollection(MediaCollectionEnum::PROFILE_IMAGE)
            ->singleFile()
            ->useDisk('avatar')
            ->useFallbackUrl('/storage/avatars/default.png');
    }
}
