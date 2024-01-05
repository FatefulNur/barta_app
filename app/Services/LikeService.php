<?php

namespace App\Services;

use App\Models\Like;

class LikeService
{
    public function store(array $data)
    {
        return Like::where('post_id', $data['post_id'])
            ->where('user_id', auth()->id())
            ->firstOrCreate([
                'user_id' => auth()->id(),
                ...$data,
            ]);
    }
}
