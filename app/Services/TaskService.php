<?php

namespace App\Services;

use App\Enums\TaskStatusEnum;
use App\Models\Task;

class TaskService
{
    public function getTasks()
    {
        return Task::with('user')->get();
    }

    public function getTaskById(int $id): Task
    {
        return Task::findOrFail($id);
    }

    public function createTask(array $data): Task
    {
        return Task::create($data);
    }

    public function updateTask(Task $task, array $data): Task
    {
        $task->update($data);
        return $task;
    }

    public function deleteTask(Task $task): void
    {
        $task->delete();
    }

    public function changeStatus(Task $task, TaskStatusEnum $status): Task
    {
        $task->update(['status' => $status->value]);
        return $task;
    }

    public function assignUserToTask(Task $task, int $userId): Task
    {
        $task->update(['user_id' => $userId]);
        return $task;
    }
}
