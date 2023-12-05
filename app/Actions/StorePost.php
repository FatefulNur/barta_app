<?php

namespace App\Actions;

use App\Constants\MediaCollectionName;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\DB;

class StorePost
{
    public function handle(StorePostRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $post = $request->user()->posts()->create($request->safe()->only('body'));

            $request->hasFile('picture') &&
                $post
                    ->addMedia($request->file('picture'))
                    ->toMediaCollection(MediaCollectionName::POST_IMAGE);

            return $post;
        }, 3);
    }
}
