<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function edit(User $user): bool
    {
        return $user->isAuthor();
    }

    public function update(User $user): bool
    {
        return $user->isAuthor();
    }
}
