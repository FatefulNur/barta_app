<?php

namespace App\Services;

use App\Constants\MediaCollectionName;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    public function update(array $data, $image = null)
    {

        return DB::transaction(function () use ($data, $image) {
            $user = auth()->user();

            if ($data['password']) {
                $data['password'] = Hash::make($data['password']);
            } else {
                $data['password'] = $user->password;
            }

            if ($image) {
                $user->addMedia($image)
                    ->toMediaCollection(MediaCollectionName::PROFILE_IMAGE);
            }

            $user->update($data);

            return $user;
        }, 3);
    }
}
