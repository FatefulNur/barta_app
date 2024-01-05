<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Notifications\LikeSent;
use App\Services\LikeService;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, LikeService $likeService)
    {
        $like = $likeService->store($request->only('post_id'));

        $loadedLike = $like->load(['post:id,user_id', 'post.user:id']);

        if (!$loadedLike->post->user->isAuthor()) {
            $loadedLike->post->user->notify(new LikeSent($like));
        }

        return $like;
    }

    public function destroy(Like $like)
    {
        return $like->delete();
    }
}
