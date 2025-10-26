<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\TaskStatus;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'due_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'date',
        'status' => TaskStatus::class,
    ];

    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include tasks for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include pending tasks.
     */
    public function scopePending($query)
    {
        return $query->where('status', TaskStatus::PENDING);
    }

    /**
     * Scope a query to only include in progress tasks.
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', TaskStatus::IN_PROGRESS);
    }

    /**
     * Scope a query to only include completed tasks.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', TaskStatus::COMPLETED);
    }

    /**
     * Scope a query to order tasks by due date.
     */
    public function scopeOrderByDueDate($query, $direction = 'asc')
    {
        return $query->orderBy('due_date', $direction);
    }

    /**
     * Scope a query to include overdue tasks.
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
                    ->whereNotIn('status', [TaskStatus::COMPLETED]);
    }

    /**
     * Check if task is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === TaskStatus::COMPLETED;
    }

    /**
     * Check if task is pending.
     */
    public function isPending(): bool
    {
        return $this->status === TaskStatus::PENDING;
    }

    /**
     * Check if task is in progress.
     */
    public function isInProgress(): bool
    {
        return $this->status === TaskStatus::IN_PROGRESS;
    }

    /**
     * Check if task is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->due_date->isPast() && !$this->isCompleted();
    }
}