<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Actions\UpdateProfile;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function index(User $user): View
    {
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

        return view('profile.index', compact('user', 'posts', 'commentsCountOfUserPosts'));
    }

    public function edit(User $user): View
    {
        abort_if(!$this->isAuthor($user->id), 403);

        return view('profile.edit', compact('user'));
    }

    public function update(ProfileUpdateRequest $request, UpdateProfile $updateProfile): RedirectResponse
    {
        abort_if(!$this->isAuthor($request->user()->id), 403);

        $updateProfile->handle($request);

        return back()->with('success', 'Your profile has been updated');
    }
}
