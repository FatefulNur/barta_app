<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $firstName = Str::of(Auth::user()->name)->before(' ');
        $posts = DB::table('posts')
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

        return view('post.index', compact('posts', 'firstName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $postData = array_merge(
            $request->validated(),
            [
                'user_id' => $request->user()->id,
                'created_at' => now(),
            ],
        );

        DB::table('posts')->insert($postData);

        return back()->with('success', 'Post has been created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        $query = DB::table('posts')
            ->where('posts.id', $id);

        $query->increment('view_count');

        $post = $query
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->select(
                'posts.id',
                'body',
                'user_id',
                'view_count',
                'users.name',
                'users.username',
                'posts.created_at',
            )
            ->first();

        abort_if(!$post, 404);

        $comments = DB::table('comments')
            ->where('post_id', $id)
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->select(
                'comments.id',
                'body',
                'user_id',
                'name',
                'username',
                'comments.created_at',
            )
            ->get();

        return view('post.show', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $query = DB::table('posts')
            ->where('id', $id);

        abort_if(!$query->first(), 404);

        abort_if(!$this->isAuthor($query->first()->user_id), 403);

        $post = $query
            ->select('id', 'body')
            ->first();

        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, int $id): RedirectResponse
    {
        $query = DB::table('posts')
            ->where('id', $id);

        abort_if(!$this->isAuthor($query->first()->user_id), 403);

        $updatedPost = array_merge(
            $request->validated(),
            [
                'updated_at' => now(),
            ],
        );

        $query->update($updatedPost);

        return to_route(
            'posts.show',
            ['post' => $id],
        )->with('success', 'Post has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $query = DB::table('posts')
            ->where('id', $id);

        abort_if(!$this->isAuthor($query->first()->user_id), 403);

        $query->delete();

        return to_route('posts.index')->with('success', 'Post has been deleted successfully');
    }
}
