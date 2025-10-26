<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->resource['user_id'],
            'user_name' => $this->resource['user_name'],
            'user_email' => $this->resource['user_email'],
            'completed_tasks_count' => $this->resource['completed_tasks_count'],
            'completed_tasks' => $this->resource['completed_tasks'],
        ];
    }
}