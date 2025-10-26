<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserReportResource;
use App\Http\Resources\PaginatedCollection;
use App\Traits\ApiResponse;

class ReportController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly AdminService $adminService
    )
    {
    }

    /**
     * Get completed tasks report grouped by user
     */
    public function completedTasks(Request $request): JsonResponse
    { 
            $perPage = $request->get('per_page', 10);
            $report = $this->adminService->getCompletedTasksReport($perPage);

            $extra = [
                'report_generated_at' => now()->toISOString(),
                'total_users_with_completed_tasks' => $report['pagination']['total'],
            ];

            $data = new PaginatedCollection($report['data'], UserReportResource::class, $extra);

            return $this->successResponse($data, 'Completed tasks report retrieved successfully', 200);
    }
}