<?php

namespace App\Http\Controllers\Api;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Services\TaskService;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Requests\Api\Task\StoreTaskRequest;
use App\Http\Requests\Api\Task\UpdateTaskRequest;
use App\Http\Requests\Api\Task\UpdateTaskStatusRequest;
use Illuminate\Routing\Controllers\HasMiddleware;

class TaskController extends Controller implements HasMiddleware
{
    public function __construct(
        private TaskService $taskService
    ) {
    }

    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'role:manager', only: ['index', 'create', 'destroy']),
        ];

    }

    public function index()
    {
        $tasks = $this->taskService->getTasks();

        return response()->json([
            'tasks' => TaskResource::collection($tasks),
        ]);
    }

    public function show(int $id)
    {
        $task = $this->taskService->getTaskById($id);

        return response()->json([
            'task' => new TaskResource($task),
        ]);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->createTask($request->validated());

        return response()->json([
            'task' => new TaskResource($task),
        ], Response::HTTP_CREATED);
    }

    public function update(UpdateTaskRequest $request, int $id)
    {
        $task = $this->taskService->getTaskById($id);

        $this->authorize('update', $task);

        $task = $this->taskService->updateTask($task, $request->validated());

        return response()->json([
            'task' => new TaskResource($task),
        ]);
    }

    public function destroy(int $id)
    {
        $task = $this->taskService->getTaskById($id);

        $this->taskService->deleteTask($task);

        return response()->json([
            'message' => 'Task deleted successfully',
        ]);
    }

    public function updateStatus(UpdateTaskStatusRequest $request, int $id)
    {
        $task = $this->taskService->getTaskById($id);
        $this->authorize('update', $task);

        $status = TaskStatusEnum::getObj($request->status);
        $this->taskService->changeStatus($task, $status);

        return response()->json([
            'message' => 'Task status updated successfully',
        ]);
    }

}
