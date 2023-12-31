<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{
    public function __construct(protected PostService $postService)
    {

    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $this->postService->store(
            $request->safe()->except('picture'),
            $request->hasFile('picture') ? $request->file('picture') : null,
        );

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
        $this->authorize('edit', $post);

        return view('post.edit', compact('post'));
    }

    public function update(StorePostRequest $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        $this->postService->update(
            $post,
            $request->safe()->except('picture'),
            $request->hasFile('picture') ? $request->file('picture') : null,
        );

        return to_route(
            'posts.show',
            ['post' => $post->id],
        )->with('success', 'Post has been updated successfully');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        $post->delete();

        return to_route('home')->with('success', 'Post has been deleted successfully');
    }
}
