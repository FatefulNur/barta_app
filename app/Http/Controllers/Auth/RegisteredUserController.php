<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('register');
    }

    public function store(RegisterUserRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());

        if ($user) {
            Auth::login($user);
        }

        return to_route('login');
    }
}
