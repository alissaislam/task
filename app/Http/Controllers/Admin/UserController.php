<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiResponse;

class UserController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly AdminService $adminService
    )
    {
    }

    /**
     * Get all users
     */
    public function index(): JsonResponse
    {
        $users = $this->adminService->getAllUsers();

        return $this->successResponse(
            UserResource::collection($users),
            'Users retrieved successfully',
            200
        );
    }

    /**
     * Delete a user
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->adminService->deleteUser($id);

        if (!$deleted) {
            return $this->errorResponse('User not found or cannot delete admin user.', 404);
        }

        return $this->successResponse(null, 'User deleted successfully.', 200);
    }
}