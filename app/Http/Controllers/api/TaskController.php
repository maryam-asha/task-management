<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Service\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{

    public function __construct(protected TaskService $taskService) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $tasks = $this->taskService->getTasks($request);
        return response()->json([
            'message' => 'Tasks retrieved successfully',
            'tasks' => TaskResource::collection($tasks),
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        Gate::authorize('create', Task::class);
        $task = $this->taskService->createTask($request->validate(), auth()->id());
        return response()->json([
            'message' => 'Task created successfully',
            'task' => new TaskResource($task->load(['user', 'status'])),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): JsonResponse
    {
        Gate::authorize('view', $task);
        return response()->json([
            'data' => new TaskResource($task),
            'message' => 'Task retrieved successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Task $task): JsonResponse
    {

        Gate::authorize('update', $task);
        $task = $this->taskService->updateTask($task, $request->validated());
        return response()->json([
            'message' => 'Task updated successfully',
            'task' => new TaskResource($task),
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): JsonResponse
    {
        Gate::authorize('delete', $task);
        $this->taskService->deleteTask($task);
        return response()->json([
            'message' => 'Task deleted successfully',
        ], Response::HTTP_NO_CONTENT);
    }
}
