<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Traits\ApiResponse;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly AdminService $adminService
    )
    {
    }

    /**
     * Admin login
     */
    public function login(AdminLoginRequest $request): JsonResponse
    {
        $admin = $this->adminService->authenticate($request->validated());

        if (!$admin) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect or you are not an admin.'],
            ]);
        }

        $token = $admin->createToken('admin-token')->plainTextToken;

        $data = [
            'user' => new UserResource($admin),
            'token' => $token,
        ];

        return $this->successResponse($data, 'Login successful', 200);
    }

    /**
     * Admin logout
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse(null, 'Logout successful', 200);
    }

    /**
     * Get current admin user
     */
    public function user(Request $request): JsonResponse
    {
        return $this->successResponse(
            new UserResource($request->user()),
            'User retrieved successfully',
            200
        );
    }
}