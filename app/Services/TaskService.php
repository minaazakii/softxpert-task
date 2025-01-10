<?php

namespace App\Services;

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
}
