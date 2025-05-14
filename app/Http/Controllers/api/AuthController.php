<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Service\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function __construct(protected AuthService $authService) {}

    public function register(RegisterRequest $request): JsonResponse
    {

        $response = $this->authService->register($request->validated());

        return response()->json([
            'message' => 'User created successfully',
            'token' => $response['token']
        ], Response::HTTP_CREATED);
    }
    public function login(LoginRequest $request): JsonResponse
    {

        $response = $this->authService->login($request->validated());

        return response()->json([
            'message' => 'Login successful',
            'token' => $response['token'],
            'user' => UserResource::make($response['user']),
        ]);
    }
    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json([
            'message' => 'Logged out successfully'
        ], Response::HTTP_OK);
    }
}
