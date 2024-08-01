<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);;
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        $result = $this->authService->login($credentials);
        if (isset($result['token'])) {
            return response()->json(['access_token' => $result['token']], $result['status']);
        }
        return response()->json(['error' => $result['error']], $result['status']);
    }

    public function register(AuthRequest $request)
    {
        try {
            $result = $this->authService->register($request);
            return response()->json(['access_token' => $result['token']], $result['status']);
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 422);
        }
    }

    public function logout()
    {
        $result = $this->authService->logout();
        return response()->json(['message' => $result['message']], $result['status']);
    }


}
