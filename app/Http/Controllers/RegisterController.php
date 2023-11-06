<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\RegisterUserRequest;

class RegisterController extends Controller
{
    public function index(): View
    {
        return view("register");
    }

    public function register(RegisterUserRequest $request): RedirectResponse
    {
        $userData = $request->validated();

        $userData["password"] = Hash::make($userData["password"]);

        DB::table("users")->insert($userData);

        return to_route("login")->with("success", "You have registered successfully");
    }
}
