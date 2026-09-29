<?php

namespace App\Repository\User;

use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    private const PER_PAGE = 10;

    public function getUsersPaginated(): LengthAwarePaginator
    {
        return User::query()
            ->with('applications')
            ->paginate(self::PER_PAGE);
    }

    public function store(UserStoreRequest $userStoreRequest): ?User
    {
        $validated = $userStoreRequest->validated();

        $validated['password'] = Hash::make($userStoreRequest->password);

        $user = User::create($validated);

        if ($userStoreRequest->file('avatar')) {
            $user->avatar = last(explode('/', $userStoreRequest->file('avatar')->store('avatars', 'public')));
            $user->save();
        }

        Cache::put('user_' . $user->id, $user, 14400);
        return $user;
    }

    public function update(UserUpdateRequest $userUpdateRequest, User $user): ?User
    {
        if ($userUpdateRequest->password) {
            $user->password = Hash::make($userUpdateRequest->password);
        }
        if ($userUpdateRequest->contact_types) {
            $syncData = [];
            foreach ($userUpdateRequest->contact_types as $contactType) {
                $syncData[$contactType['id']] = [
                    'subject' => $contactType['value'],
                ];
            }
            $user->contactTypes()->sync($syncData);
        }

        $user->name = $userUpdateRequest->name;
        $user->email = $userUpdateRequest->email;
        $user->role = $userUpdateRequest->role;
        if ($userUpdateRequest->file('avatar')) {
            $user->removeAvatar();
            $user->avatar = last(explode('/', $userUpdateRequest->file('avatar')->store('avatars', 'public')));
        }
        $user->save();

        return $user;
    }

    public function destroy(User $user): ?bool
    {
        $user->removeAvatar();
        return $user->delete();
    }
}
