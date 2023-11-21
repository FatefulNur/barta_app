<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function index(int $id): View
    {
        $user = DB::table("users")->where("id", $id)->first();

        $firstName = Str::of($user->name)->before(" ");
        $fullName = Str::of($user->name)->title();
        $bio = $user->bio ?? "Less Talk, More Code 💻";
        $posts = DB::table("posts")->where("user_id", $user->id)
            ->join("users", "posts.user_id", "=", "users.id")
            ->select(
                "uuid",
                "body",
                "user_id",
                "view_count",
                "users.name",
                "users.username",
                "posts.created_at",
            )
            ->orderByDesc("created_at")
            ->get();

        return view("profile.index", compact("firstName", "fullName", "bio", "posts"));
    }

    public function edit(int $id): View
    {
        $user = DB::table("users")->where("id", $id)->first();

        abort_if(!$this->isAuthor($user->id), 403);

        $name = $user->name;
        $username = $user->username;
        $email = $user->email;
        $bio = $user->bio ?? "Less Talk, More Code 💻";

        return view("profile.edit", compact("name", "username", "email", "bio"));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        abort_if(!$this->isAuthor($request->user()->id), 403);

        $userData = $request->validated();

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($userData['password']);
        } else {
            $userData['password'] = Auth::user()->password;
        }

        DB::table("users")->where("id", $request->user()->id)->update($userData);

        return back()->with("success", "Your profile has been updated");
    }
}
