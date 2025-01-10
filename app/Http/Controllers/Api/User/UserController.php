<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userTasks()
    {
        $tasks = (new TaskService)->getTasks(['user_id' => auth()->id()]);
        return response()->json([
            'tasks' => TaskResource::collection($tasks),
        ]);
    }
}
