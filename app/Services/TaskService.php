<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskService
{
    /**
     * Summary of createTask
     * @param array $data
     * @throws \Exception
     * @return void
     */
    public function createTask(array $data)
    {
        try {
            DB::beginTransaction();
            Task::create($data);
            Cache::forget('tasks_');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('something went wrong: ' . $e->getMessage());
            throw new \Exception('Error while creating this task');
        }
    }
    /**
     * Summary of listAllTask
     * @param array $filters
     * @param int $perPage
     * @throws \Exception
     */
    public function listAllTask(array $filters, int $perPage)
    {
        try {
            $cacheKey = 'tasks_' . md5(json_encode($filters) . $perPage . request('page', 1));

            $tasks = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($filters, $perPage) {
                return Task::with(['subtasks'])
                    ->when($filters['status'] ?? null, function ($query, $status) {
                        $query->status($status);
                    })
                    ->when($filters['title'] ?? null, function ($query, $title) {
                        $query->title($title);
                    })
                    ->when($filters['user_id'] ?? null, function ($query, $userId) {
                        $query->UserID($userId);
                    })
                    ->paginate($perPage);
            });

            return $tasks;
        } catch (\Exception $e) {
            Log::error('error listing tasks ' . $e->getMessage());
            throw new \Exception('there is something wrong');
        }
    }
    /**
     * Summary of updateTask
     * @param \App\Models\Task $task
     * @param array $data
     * @throws \Exception
     * @return void
     */
    public function updateTask(Task $task, array $data)
    {
        try {
            DB::beginTransaction();
            $task->update(array_filter($data));
            Cache::forget('tasks_');
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('something wrong while updating ' . $e->getMessage());
            throw new \Exception('wrong while updating this task');
        }
    }
    /**
     * Summary of showTask
     * @param \App\Models\Task $task
     * @return string|Task
     */
    public function showTask(Task $task)
    {
        try {
            return $task->load(['subtasks']);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Summary of deleteTask
     * @param \App\Models\Task $task
     * @throws \Exception
     * @return void
     */
    public function deleteTask(Task $task)
    {
        try {
            DB::beginTransaction();
            $task->delete();
            Cache::forget('tasks_');
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('wrong while delete ' . $e->getMessage());
            throw new \Exception('wrong while deleting this task');
        }
    }

}

