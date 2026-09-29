<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    public function created(User $user): void
    {
        Cache::put('user_' . $user->id, $user, 14400);
    }

    public function updated(User $user): void
    {
        Cache::put('user_' . $user->id, $user, 14400);
    }

    public function deleted(User $user): void
    {
        Cache::forget('user_' . $user->id);
    }

    public function restored(User $user): void
    {

    }

    public function forceDeleted(User $user): void
    {
    }
}
