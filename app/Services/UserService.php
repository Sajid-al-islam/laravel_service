<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use App\Events\UserSaved;
use App\Models\User;
use Illuminate\Support\Arr;

class UserService implements UserServiceInterface
{
    public function getAllUsers()
    {
        return User::whereNot('id', auth()->user()->id)->paginate(10);
    }

    public function getUserById($id)
    {
        return User::with('addresses')->findOrFail($id);
    }

    public function createUser(array $data)
    {
        $user = User::create($data);

        event(new UserSaved($user));

        return $user;
    }

    public function updateUser($id, array $data)
    {
        $user = User::findOrFail($id);
        if(empty($data['password'])) {
            $data = Arr::except($data,['password']);
        }
        $user->update($data);
        event(new UserSaved($user));
        return $user;
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return $user;
    }

    public function getTrashedUsers()
    {
        return User::onlyTrashed()->get();
    }

    public function restoreUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return $user;
    }

    public function forceDeleteUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();
        return $user;
    }
}
