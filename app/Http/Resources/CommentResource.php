<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'user' => UserResource::make($this->whenLoaded('user')),
            'created_at' => $this->created_at->diffForHumans(),
            'can' => [
                'edit' => $request->user()->id === $this->user_id,
                'update' => $request->user()->id === $this->user_id,
                'delete' => $request->user()->id === $this->user_id,
            ]
        ];
    }
}
