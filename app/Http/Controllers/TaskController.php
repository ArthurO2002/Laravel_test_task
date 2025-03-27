<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Task;

class TaskController extends Controller
{
    protected TaskService $service;

    public function __construct(TaskService $service)  {
        $this->service = $service;
    }

    public function index(Request $request) {
        $page = $request->query('page', 1);

        $data = $this->service->getAllTasks($page);
        return response()->json($data);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $data = $this->service->createTask($validated);
        return response()->json($data, 201);
    }

    public function update(Request $request, Task $task) {

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $data = $this->service->updateTask($task, $validated);
        return response()->json($data);
    }

    public function destroy(Request $request, Task $task) {
        $this->service->deleteTask($task);
        return response()->json(null, 204);
    }
}
