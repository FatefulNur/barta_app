<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileUpdateRequest;

class UpdateProfileAction
{
    public function handle(ProfileUpdateRequest $request): User
    {
        $userData = $request->validated();

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($userData['password']);
        } else {
            $userData['password'] = auth()->user()->password;
        }

        return User::where('id', $request->user()->id)->update($userData);
    }
}
