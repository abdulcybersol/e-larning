<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\UserService;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, UserService $userService) {
        try {
            $data = $request->validated();

            $role = $request->get('role', 'student');

            $user = $userService->createUser($data, $role);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User Created Successfully',
                'data' => $user,
                'token' => $token,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function login(LoginRequest $request) {
        try {
            $validate = $request->validated();
            $user = User::where('email', $validate['email'])->first();

            if (!$user || !Hash::check($validate['password'], $user->password)) {
                return response()->json([
                    'message' => 'Invalid Credential',
                ], 401);
            }

            if ($user->hasRole('teacher')) {
                $user->load('teacher');
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login Successfully',
                'data' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'city' => $user->city,
                    'state' => $user->state,
                    'country' => $user->country,
                    'role' => $user->getRoleNames()->first(),
                    'teacher' => $user->teacher,
                ],
                'token' => $token
            ]);

        } catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
