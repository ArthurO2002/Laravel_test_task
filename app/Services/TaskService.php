<?php

namespace App\Services;
use App\Enums\TaskListSortingEnum;
use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{

    /**
     * Provides tasks by required pagination and status filtration
     * @param int $page
     * @param boolean|null $status
     * @param TaskListSortingEnum $sort
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllTasks(int $page = 1, ?bool $status = null, TaskListSortingEnum $sort = TaskListSortingEnum::DESC, int $perPage = 5): LengthAwarePaginator
    {
        $query = Task::query();

        if (!is_null($status)) {
            $query->where('status', $status);
        }

        $query->orderBy('created_at', $sort->value);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Create ITask in DB
     *
     * @param array $data
     * @return Task|null
     */
    public function createTask(array $data): ?Task
    {
        return Task::create($data);
    }

    /**
     * Update task in DB
     *
     * @param Task $task
     * @param array $data
     * @return Task|null
     */
    public function updateTask(Task $task, array $data): ?Task
    {
        $task->update($data);
        return $task->fresh();
    }

    /**
     * Delete task from DB
     * @param Task $task
     * @return true
     */
    public function deleteTask(Task $task): true
    {
        $task->delete();
        return true;
    }
}
