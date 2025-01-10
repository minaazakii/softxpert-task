<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userTasks(Request $request)
    {
        $filters = $request->except('user_id');
        $filters['user_id'] = auth()->id();
        $tasks = (new TaskService)->getTasks($filters);
        
        return response()->json([
            'tasks' => TaskResource::collection($tasks),
        ]);
    }
}
