<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TaskController extends Controller
{
    protected TaskService $service;

    public function __construct(TaskService $service)  {
        $this->service = $service;
    }

    public function index() {
        $data = $this->service->getAllTasks();
        return response()->json($data, 201);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = $this->service->createTask($validated);
        return response()->json($data, 201);
    }
}
