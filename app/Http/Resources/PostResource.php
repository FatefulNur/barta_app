<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class PostResource extends JsonResource
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
            'body' => $this->body,
            'user_id' => $this->user_id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'view_count' => $this->view_count,
            'post_image' => $this->getPostImage(),
            'created_at' => $this->created_at->diffForHumans(),
            'comments_count' => $this->whenCounted('comments'),
            'can' => [
                'edit' => auth()->id() === $this->user_id,
                'delete' => auth()->id() === $this->user_id,
            ],
        ];
    }
}
