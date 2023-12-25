<?php

namespace App\Services;

use App\Constants\MediaCollectionName;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostService
{
    public function store(array $data, $image = null)
    {
        return DB::transaction(function () use ($data, $image) {
            $post = auth()->user()->posts()->create($data);

            if ($image) {
                $post
                    ->addMedia($image)
                    ->toMediaCollection(MediaCollectionName::POST_IMAGE);
            }

            return $post;
        }, 3);
    }

    public function update(Post $post, array $data, $image = null)
    {
        return DB::transaction(function () use ($post, $data, $image) {
            $post->update($data);

            if ($image) {
                $post
                    ->addMedia($image)
                    ->toMediaCollection(MediaCollectionName::POST_IMAGE);
            }

            return $post;
        }, 3);
    }
}
