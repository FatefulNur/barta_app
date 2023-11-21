<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $firstName = Str::of(Auth::user()->name)->before(" ");
        $posts = DB::table("posts")
            ->join("users", "posts.user_id", "=", "users.id")
            ->select(
                "id",
                "body",
                "user_id",
                "view_count",
                "users.name",
                "users.username",
                "posts.created_at",
            )
            ->orderByDesc("created_at")
            ->get();

        return view("post.index", compact("posts", "firstName"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $postData = array_merge(
            $request->validated(),
            [
                "user_id" => $request->user()->id,
                "created_at" => now(),
            ],
        );

        DB::table("posts")->insert($postData);

        return back()->with("success", "Post has been created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $query = DB::table("posts")
            ->where("id", $id);

        $query->increment("view_count");

        $post = $query
            ->join("users", "posts.user_id", "=", "users.id")
            ->select(
                "id",
                "body",
                "user_id",
                "view_count",
                "users.name",
                "users.username",
                "posts.created_at",
            )
            ->first();

        return view("post.show", compact("post"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $query = DB::table("posts")
            ->where("id", $id);

        if (!$this->isAuthor($query->first()->user_id)) {
            abort(403);
        }

        $post = $query
            ->select("id", "body")
            ->first();

        return view("post.edit", compact("post"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, int $id)
    {
        $query = DB::table("posts")
            ->where("id", $id);

        if (!$this->isAuthor($query->first()->user_id)) {
            abort(403);
        }

        $updatedPost = array_merge(
            $request->validated(),
            [
                "updated_at" => now(),
            ],
        );

        $query->update($updatedPost);

        return to_route(
            "posts.show",
            ["post" => $id],
        )->with("success", "Post has been updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $query = DB::table("posts")
            ->where("id", $id);

        if (!$this->isAuthor($query->first()->user_id)) {
            abort(403);
        }

        $query->delete();

        return to_route("posts.index")->with("success", "Post has been deleted successfully");
    }
}
