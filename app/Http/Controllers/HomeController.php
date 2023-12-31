<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostCollection;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $posts = Post::select([
            'id',
            'body',
            'user_id',
            'view_count',
            'created_at',
        ])->withCount('comments')
            ->with('user:id,name,username')
            ->orderByDesc('id')
            ->cursorPaginate(10);

        $postsJson = PostCollection::make($posts);

        if ($request->wantsJson()) {
            return $postsJson;
        }

        return inertia()->render('Posts/Index', [
            'posts' => $postsJson,
        ]);
    }
}
