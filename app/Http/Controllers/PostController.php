<?php

namespace App\Http\Controllers;

use App\Actions\StorePost;
use App\Models\Post;
use Illuminate\View\View;
use App\Enums\MediaCollectionEnum;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::select([
            'id',
            'body',
            'user_id',
            'view_count',
            'created_at',
        ])->withCount('comments')
            ->with('user:id,name,username')
            ->orderByDesc('created_at')
            ->get();

        return view('post.index', compact('posts'));
    }

    public function store(StorePostRequest $request, StorePost $storePost): RedirectResponse
    {
        $storePost->handle($request);

        return back()->with('success', 'Post has been created successfully');
    }

    public function show(Post $post): View
    {
        $post->update(['view_count' => $post->view_count + 1]);

        $post->load([
            'user:id,name,username',
            'comments:id,body,user_id,post_id,created_at',
            'comments.user:id,name,username',
        ])->loadCount('comments');

        return view('post.show', compact('post'));
    }

    public function edit(Post $post): View
    {
        abort_if(!$this->isAuthor($post->user_id), 403);

        return view('post.edit', compact('post'));
    }

    public function update(StorePostRequest $request, Post $post): RedirectResponse
    {
        abort_if(!$this->isAuthor($post->user_id), 403);

        $request->hasFile('picture') &&
            $post
                ->addMedia($request->file('picture'))
                ->toMediaCollection(MediaCollectionEnum::POST_IMAGE);

        $post->update($request->safe()->only('body'));

        return to_route(
            'posts.show',
            ['post' => $post->id],
        )->with('success', 'Post has been updated successfully');
    }

    public function destroy(Post $post): RedirectResponse
    {
        abort_if(!$this->isAuthor($post->user_id), 403);

        $post->delete();

        return to_route('posts.index')->with('success', 'Post has been deleted successfully');
    }
}
