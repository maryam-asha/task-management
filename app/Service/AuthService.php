<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data): array
    {
       
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role'] ?? null,
        ]);
        $token = $user->createToken('api-token')->plainTextToken;
        return [
            'token' => $token,
        ];
    }
    public function login(array $credentials): array
    {

        if (! Auth::attempt($credentials)) {
            throw new \Exception('Invalid credentials', Response::HTTP_UNAUTHORIZED);
        }
        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;
        return [
            'token' => $token,
            'user' => $user,
        ];
    }

    public function logout(): bool
    {
        return Auth::user()->currentAccessToken()->delete();
    }
}
