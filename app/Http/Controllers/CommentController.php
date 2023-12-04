<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(StorePostRequest $request, Post $post): RedirectResponse
    {
        $post->comments()->create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return back()->with('success', 'Comment has been created successfully');
    }

    public function edit(Post $post, Comment $comment): RedirectResponse
    {
        abort_if(!$this->isAuthor($comment->user_id), 403);

        return back()
            ->with('editComment', $comment->body)
            ->with('commentId', $comment->id);
    }

    public function update(Request $request, Post $post, Comment $comment): RedirectResponse
    {
        abort_if(!$this->isAuthor($comment->user_id), 403);

        $validator = Validator::make($request->all(), [
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('commentId', $comment->id)
                ->withErrors($validator)
                ->withInput();
        }

        $comment->update($validator->safe()->only('body'));

        return back()->with('success', 'Comment has been updated successfully');
    }

    public function destroy(Post $post, Comment $comment): RedirectResponse
    {
        abort_if(!$this->isAuthor($comment->user_id), 403);

        $comment->delete();

        return back()->with('success', 'Comment has been deleted successfully');
    }
}
