<?php

namespace App\Services;
use App\Models\Task;

class TaskService
{
    public function getAllTasks($page = 1, $status = null, $perPage = 5)
    {
        $query = Task::query();

        if ($status !== null) {
            $query->where('status', $status);
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function createTask(array $data)
    {
        return Task::create($data);
    }

    public function updateTask(Task $task, array $data) {
        $task->update($data);
        return $task->fresh();
    }

    public function deleteTask(Task $task) {

        if (!$task->exists) {
            throw new \Exception("Task not found.");
        }

        $task->delete();
        return true;
    }
}
