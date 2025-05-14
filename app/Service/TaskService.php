<?php

namespace App\Service;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskService
{
    /**
     * Retrieve tasks with optional filtering.
     *
     * @param Request $request
     * @return array
     */
    public function getTasks(Request $request)
    {
        $tasks = Task::query()
            ->when($request->search, fn($query) => $query->where('title', 'like', "%{$request->search}%")
                ->orWhere('description', 'like', "%{$request->search}%"))
            ->when($request->priority, fn($query) => $query->where('priority', $request->priority))
            ->when($request->status_id, fn($query) => $query->where('status_id', $request->status_id))
            ->with(['user', 'status'])
            ->get();
        return $tasks;
    }
    /**
     * Create a new task.
     *
     * @param array $data
     * @param int $userId
     * @return Task
     */
    public function createTask(array $data, int $userId): Task
    {
        return Task::create($data + ['user_id' => $userId]);
    }
    /**
     * Update an existing task.
     *
     * @param Task $task
     * @param array $data
     * @return Task
     */
    public function updateTask(Task $task, array $data): Task
    {
        $task->update($data);
        return $task;
    }
    /**
     * Delete a task.
     *
     * @param Task $task
     * @return bool
     */
    public function deleteTask(Task $task): bool {
        return $task->delete();
    }
}
