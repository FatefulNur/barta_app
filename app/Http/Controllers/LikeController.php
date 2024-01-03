<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        return Like::where('post_id', $request->input('post_id'))
            ->where('user_id', $request->user()->id)
            ->firstOrCreate([
                'user_id' => $request->user()->id,
                ...$request->only('post_id'),
            ]);
    }

    public function destroy(Like $like)
    {
        return $like->delete();
    }
}
