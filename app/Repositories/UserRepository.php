<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{

    public function all($keyword)
    {
        $query = User::latest();
        if ($keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }
        return $query->paginate(10);
    }
    public function store($userRequest)
    {
        $user = User::create([
            'name' => $userRequest['name'],
            'email' => $userRequest['email'],
            'password' => Hash::make($userRequest['password'])
        ]);
        $user->syncRoles($userRequest['role']);
    }

    public function update($userRequest, $user)
    {
        $user->update($userRequest);
        $user->syncRoles($userRequest['role']);
    }

    public function destroy($user)
    {
        $user->delete();
    }
}
