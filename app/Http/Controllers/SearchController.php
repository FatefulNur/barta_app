<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\Builder;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = User::query()->when($request->query('q'), function (Builder $builder) use ($request) {
            $builder->where('username', 'LIKE', '%' . $request->query('q') . '%')
                ->orWhere('name', 'LIKE', '%' . $request->query('q') . '%')
                ->orWhere('email', 'LIKE', '%' . $request->query('q') . '%');
        })->firstOrFail();

        $posts = Post::select([
            'id',
            'body',
            'user_id',
            'view_count',
            'created_at',
        ])->where('user_id', $user->id)
            ->withCount('comments')
            ->with('user:id,name,username')
            ->orderByDesc('created_at')
            ->get();

        $commentsCountOfUserPosts = Comment::whereIn('post_id', $posts->pluck('id'))->count();

        return inertia()->render('Profiles/Index', [
            'user' => UserResource::make($user),
            'posts' => PostResource::collection($posts),
            'commentsCountOfUserPosts' => $commentsCountOfUserPosts,
        ]);
    }
}
