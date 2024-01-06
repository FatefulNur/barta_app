<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Notifications\CommentSent;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Post $post): RedirectResponse
    {
        $comment = $post->comments()->create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        $loadedComment = $comment->load(['post:id,user_id', 'post.user:id,name,email']);

        if (!$loadedComment->post->user->isAuthor()) {
            $loadedComment->post->user->notify(new CommentSent($comment));
        }

        return back()->with('success', 'Comment has been created successfully');
    }

    public function update(UpdateCommentRequest $request, Post $post, Comment $comment): RedirectResponse
    {
        $this->authorize('update', $comment);

        $comment->update($request->validated());

        return back()->with('success', 'Comment has been updated successfully');
    }

    public function destroy(Post $post, Comment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Comment has been deleted successfully');
    }
}
