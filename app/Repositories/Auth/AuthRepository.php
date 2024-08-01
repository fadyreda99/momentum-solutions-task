<?php

namespace App\Repositories\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    public function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
