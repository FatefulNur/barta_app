<?php

namespace App\Actions;

use App\Enums\MediaCollectionEnum;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePostRequest;

class StorePost
{
    public function handle(StorePostRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $post = $request->user()->posts()->create($request->safe()->only('body'));

            $request->hasFile('picture') &&
                $post
                    ->addMedia($request->file('picture'))
                    ->toMediaCollection(MediaCollectionEnum::POST_IMAGE);

            return $post;
        }, 3);
    }
}
