<?php

namespace App\Services;

use App\Enums\TaskStatusEnum;
use App\Models\Task;

class TaskService
{
    public function getTasks($filters = [])
    {
        $query = Task::query()->when(isset($filters['status']), function ($query) use ($filters) {
            return $query->where('status', $filters['status']);

        })->when(isset($filters['user_id']), function ($query) use ($filters) {
            return $query->where('user_id', $filters['user_id']);
        })->when(isset($filters['start_date']), function ($query) use ($filters) {
            return $query->where('start_date', $filters['start_date']);
        })->when(isset($filters['due_date']), function ($query) use ($filters) {
            return $query->where('due_date', $filters['due_date']);
        });

        return $query->get();
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

    public function addDependenciesToTask(Task $task, array $dependencies_ids): Task
    {
        //Remove the task id from the dependencies array if it exists in the dependencies array
        if (in_array($task->id, $dependencies_ids)) {
            $dependencies_ids = array_diff($dependencies_ids, [$task->id]);
        }

        $task->dependencies()->syncWithoutDetaching($dependencies_ids);
        return $task;
    }
}
