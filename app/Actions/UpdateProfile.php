<?php

namespace App\Actions;

use App\Enums\MediaCollectionEnum;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileUpdateRequest;

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
                ->toMediaCollection(MediaCollectionEnum::PROFILE_IMAGE);

        return $request->user()->update($userData);
    }
}
