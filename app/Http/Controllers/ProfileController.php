<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Services\ProfileService;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        $posts = Post::select([
            'id',
            'body',
            'user_id',
            'view_count',
            'created_at',
        ])->where('user_id', $user->id)
            ->withCount(['comments', 'likes'])
            ->with(['user:id,name,username', 'likes:id,user_id,post_id', 'likes.user'])
            ->orderByDesc('id')
            ->get();

        $commentsCountOfUserPosts = Comment::whereIn('post_id', $posts->pluck('id'))->count();

        return inertia()->render('Profiles/Index', [
            'user' => UserResource::make($user),
            'posts' => PostResource::collection($posts),
            'commentsCountOfUserPosts' => $commentsCountOfUserPosts,
        ]);
    }

    public function edit(User $user)
    {
        if ($user->cannot('edit', $user)) {
            abort(403);
        }

        return inertia()->render('Profiles/Edit', [
            'user' => $user,
            'profile_image' => $user->getProfileImage(),
        ]);
    }

    public function update(ProfileUpdateRequest $request, ProfileService $profileService): RedirectResponse
    {
        if ($request->user()->cannot('edit', auth()->user())) {
            abort(403);
        }

        $profileService->update(
            $request->safe()->except('avatar'),
            $request->hasFile('avatar') ? $request->file('avatar') : null,
        );

        return back()->with('success', 'Your profile has been updated');
    }
}
