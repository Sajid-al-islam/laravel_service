<?php

namespace App\Services;

use App\Contracts\UserInterface;
use App\Models\User;

class UserService implements UserInterface
{
    public function getAllUsers()
    {
        return User::whereNot('id', auth()->user()->id)->paginate(10);
    }

    public function getUserById($id)
    {
        return User::findOrFail($id);
    }

    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function updateUser($id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);
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
