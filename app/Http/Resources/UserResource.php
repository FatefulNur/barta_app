<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'profile_image' => $this->getProfileImage(),
            'first_name' => $this->firstName(),
            'full_name' => $this->fullName(),
            'username' => $this->username,
            'bio' => $this->bio,
            'is_author' => $this->isAuthor(),
        ];
    }
}
