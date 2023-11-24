<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(StorePostRequest $request, int $postId)
    {
        $commentData = array_merge(
            $request->validated(),
            [
                'user_id' => $request->user()->id,
                'post_id' => $postId,
                'created_at' => now(),
            ],
        );

        DB::table('comments')->insert($commentData);

        return back()->with('success', 'Comment has been created successfully');
    }

    public function edit(int $postId, int $commentId)
    {
        $editComment = DB::table('comments')
            ->select('body', 'post_id', 'user_id')
            ->where('id', $commentId)
            ->first();

        abort_if(! $editComment, 404);

        abort_if($postId !== $editComment->post_id, 404);

        abort_if(! $this->isAuthor($editComment->user_id), 403);

        return back()
            ->with('editComment', $editComment->body)
            ->with('commentId', $commentId);
    }

    public function update(Request $request, int $postId, int $commentId)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('commentId', $commentId)
                ->withErrors($validator)
                ->withInput();

        }

        $query = DB::table('comments')
            ->select('post_id', 'user_id')
            ->where('id', $commentId);

        abort_if(! $this->isAuthor($query->first()->user_id), 403);

        if ($postId !== $query->first()->post_id) {
            return back()->with('error', 'Comment cannot be updated:(');
        }

        $query->update($validator->safe()->only('body'));

        return back()->with('success', 'Comment has been updated successfully');
    }

    public function destroy(int $postId, int $commentId)
    {
        $query = DB::table('comments')
            ->select('post_id', 'user_id')
            ->where('id', $commentId);

        abort_if(! $this->isAuthor($query->first()->user_id), 403);

        if ($postId !== $query->first()->post_id) {
            return back()->with('error', 'Comment cannot be deleted:(');
        }

        $query->delete();

        return back()->with('success', 'Comment has been deleted successfully');
    }
}
