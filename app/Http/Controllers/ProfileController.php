<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function index(): View
    {
        $fullName = str()->of(Auth::user()->name)->title();
        $bio = Auth::user()->bio ?? "Less Talk, More Code 💻";

        return view("profile.index", compact("fullName", "bio"));
    }

    public function edit(): View
    {
        $name = Auth::user()->name;
        $username = Auth::user()->username;
        $email = Auth::user()->email;
        $bio = Auth::user()->bio ?? "Less Talk, More Code 💻";

        return view("profile.edit", compact("name", "username", "email", "bio"));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
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
