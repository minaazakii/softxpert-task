<?php

namespace App\Http\Controllers\Api;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Services\TaskService;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Task\AddDependenciesToTaskRequest;
use App\Http\Requests\Api\Task\AssignUserToTaskRequest;
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
            new Middleware(middleware: 'role:manager', only: [
                'index',
                'store',
                'destroy',
                'assignUserToTask'
            ]),
        ];

    }

    public function index(Request $request)
    {
        $filters = $request->query();
        $tasks = $this->taskService->getTasks($filters);

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

        if ($request->user_id && !auth()->user()->hasRole('manager')) {
            return response()->json([
                'message' => 'Only Managers can assign users to tasks',
            ], Response::HTTP_FORBIDDEN);
        }

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

    public function assignUserToTask(AssignUserToTaskRequest $request, int $id)
    {
        $task = $this->taskService->getTaskById($id);
        $this->taskService->assignUserToTask($task, $request->user_id);

        return response()->json([
            'message' => 'User assigned To Task successfully',
        ]);
    }

    public function updateStatus(UpdateTaskStatusRequest $request, int $id)
    {
        $task = $this->taskService->getTaskById($id);
        $this->authorize('update', $task);

        if ($request->status == TaskStatusEnum::Completed->value && !$task->canMarkAsCompleted()) {
            return response()->json([
                'message' => 'Cant Change Status To Completed Since Some Task dependencies are not completed yet',
            ], Response::HTTP_BAD_REQUEST);
        }

        $status = TaskStatusEnum::getObj($request->status);
        $this->taskService->changeStatus($task, $status);

        return response()->json([
            'message' => 'Task status updated successfully',
        ]);
    }

    public function addDependenciesToTask(AddDependenciesToTaskRequest $request, int $id)
    {
        $task = $this->taskService->getTaskById($id);
        $this->taskService->addDependenciesToTask($task, $request->dependencies_tasks_ids);

        return response()->json([
            'message' => 'Task dependencies Added successfully',
        ]);
    }

}
