<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(int $id): View
    {
        $user = DB::table('users')->where('id', $id)->first();

        abort_if(! $user, 404);

        $firstName = Str::of($user->name)->before(' ');
        $fullName = Str::of($user->name)->title();
        $bio = $user->bio ?? 'Less Talk, More Code 💻';
        $posts = DB::table('posts')
            ->where('posts.user_id', $user->id)
            ->select(
                DB::raw('COUNT(comments.id) as comments_count'),
                'posts.id',
                'posts.body',
                'posts.user_id',
                'view_count',
                'users.name',
                'users.username',
                'posts.created_at',
            )
            ->leftJoin('users', 'posts.user_id', '=', 'users.id')
            ->leftJoin('comments', 'posts.id', '=', 'comments.post_id')
            ->groupBy('posts.id')
            ->orderByDesc('created_at')
            ->get();

        $commentsCountOfUserPosts = DB::table('comments')->whereIn('post_id', $posts->pluck('id'))->count();

        return view('profile.index', compact('user', 'firstName', 'fullName', 'bio', 'posts', 'commentsCountOfUserPosts'));
    }

    public function edit(int $id): View
    {
        $user = DB::table('users')->where('id', $id)->first();

        abort_if(! $this->isAuthor($user->id), 403);

        $name = $user->name;
        $username = $user->username;
        $email = $user->email;
        $bio = $user->bio ?? 'Less Talk, More Code 💻';

        return view('profile.edit', compact('name', 'username', 'email', 'bio'));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        abort_if(! $this->isAuthor($request->user()->id), 403);

        $userData = $request->validated();

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($userData['password']);
        } else {
            $userData['password'] = Auth::user()->password;
        }

        DB::table('users')->where('id', $request->user()->id)->update($userData);

        return back()->with('success', 'Your profile has been updated');
    }
}
