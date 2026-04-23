<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    /**
     * Register API
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:6'],
            'c_password' => ['required', 'same:password'],
            'role' => ['required', 'in:admin,customer,rider,agent'],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $role = Role::where('slug', $request->role)->first();

        if (!$role) {
            return $this->sendError('Role not found.', ['role' => ['Selected role does not exist.']]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
        ]);

        $token = $user->createToken('Kukamoto')->plainTextToken;

        $success = [
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role?->slug,
                'role_name' => $user->role?->name,
            ],
        ];

        return $this->sendResponse($success, 'User registered successfully.');
    }

    /**
     * Login API
     * Allow login with email or phone
     */
    public function login(Request $request): JsonResponse
{
    $validator = Validator::make($request->all(), [
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors());
    }

    if (!Auth::attempt([
        'email' => $request->email,
        'password' => $request->password,
    ])) {
        return $this->sendError('Unauthorised.', [
            'error' => ['Invalid email or password.']
        ]);
    }

    /** @var \App\Models\User $user */
    $user = Auth::user()->load('role');

    $token = $user->createToken('Kukamoto')->plainTextToken;

    $success = [
        'token' => $token,
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'role' => $user->role?->slug,
            'role_name' => $user->role?->name,
        ],
    ];

    return $this->sendResponse($success, 'User login successfully.');
}

    /**
     * Current authenticated user
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->load('role');

        return $this->sendResponse([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role?->slug,
                'role_name' => $user->role?->name,
            ],
        ], 'Authenticated user retrieved successfully.');
    }

    /**
     * Logout API
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse([], 'User logout successfully.');
    }
}