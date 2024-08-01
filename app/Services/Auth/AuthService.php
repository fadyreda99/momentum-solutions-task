<?php

namespace App\Services\Auth;

use App\Repositories\Auth\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;


class AuthService
{
    public function __construct(private AuthRepository $authRepository)
    {
    }

    public function login(array $credentials)
    {
        if (!$token = Auth::attempt($credentials)) {
            return ['error' => 'Invalid credentials', 'status' => 401];
        }
        return ['token' => $token, 'status' => 200];
    }

    public function register($request)
    {
        $user = $this->authRepository->createUser($request->validated());
        $token = Auth::login($user);
        return ['token' => $token, 'status' => 201];
    }

    public function logout()
    {
        Auth::logout();
        return ['message' => 'Successfully logged out', 'status' => 200];
    }
}
