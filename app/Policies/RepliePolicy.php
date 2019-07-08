<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Replie;

class RepliePolicy
{
    public function destroy(User $user, Replie $reply)
    {
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}