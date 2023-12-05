<?php

namespace App\Actions;

use App\Constants\MediaCollectionName;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Hash;

class UpdateProfile
{
    public function handle(ProfileUpdateRequest $request)
    {
        $userData = $request->safe()->except('avatar');

        $userData['password'] = $request->filled('password') ? Hash::make($userData['password']) : $request->user()->password;

        $request->hasFile('avatar') &&
            $request
                ->user()
                ->addMedia($request->file('avatar'))
                ->toMediaCollection(MediaCollectionName::PROFILE_IMAGE);

        return $request->user()->update($userData);
    }
}
