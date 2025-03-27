<?php

namespace App\Http\Controllers;

use App\Enums\TaskListSortingEnum;
use App\Services\TaskService;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Task;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    protected TaskService $service;

    public function __construct(TaskService $service)  {
        $this->service = $service;
    }

    /**
     * @throws Exception
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $page = $request->query('page', 1);
        $status = $request->has('status') ? filter_var($request->query('status'), FILTER_VALIDATE_BOOLEAN) : null;
        $sort = strtolower($request->query('sort', 'desc'));

        $sort = $sort === TaskListSortingEnum::ASC->value ? TaskListSortingEnum::ASC : TaskListSortingEnum::DESC;

        $data = $this->service->getAllTasks($page, $status, $sort);
        return response()->json($data);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $validated = $validator->validated();
        $data = $this->service->createTask($validated);
        return response()->json($data, 201);
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request, Task $task): \Illuminate\Http\JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'boolean'],
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $validated = $validator->validated();
        $data = $this->service->updateTask($task, $validated);
        return response()->json($data);
    }

    /**
     * @throws Exception
     */
    public function destroy(Request $request, Task $task): \Illuminate\Http\JsonResponse
    {
        $this->service->deleteTask($task);
        return response()->json(null, 204);
    }
}
