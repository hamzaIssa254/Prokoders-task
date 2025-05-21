<?php

namespace App\Services;

use App\Models\Subtask;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SubTaskService
{
    /**
     * Summary of createSubTask
     * @param array $data
     * @throws \Exception
     * @return void
     */
    public function createSubTask(array $data)
    {
        try {
            DB::beginTransaction();
            Subtask::create($data);
            Cache::forget('subTasks_');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('something went wrong: ' . $e->getMessage());
            throw new \Exception('Error while creating this subTask');
        }
    }
    /**
     * Summary of listAllSubTask
     * @param int $perPage
     * @throws \Exception
     */
    public function listAllSubTask(int $perPage)
    {
        try {

            $cacheKey = 'subTasks_' . md5($perPage . request('page', 1));

            $tasks = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($perPage) {
                return Subtask::with(['task'])
                    ->paginate($perPage);
            });

            return $tasks;
        } catch (\Exception $e) {
            Log::error('error listing tasks ' . $e->getMessage());
            throw new \Exception('there is something wrong');
        }
    }

    /**
     * Summary of updateSubTask
     * @param \App\Models\Subtask $subTask
     * @param array $data
     * @throws \Exception
     * @return void
     */
    public function updateSubTask(Subtask $subTask, array $data)
    {
        try {
            DB::beginTransaction();
            $subTask->update(array_filter($data));
            Cache::forget('subTasks_');
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('something wrong while updating ' . $e->getMessage());
            throw new \Exception('wrong while updating this subtask');
        }
    }
    /**
     * Summary of showSubTask
     * @param \App\Models\Subtask $subTask
     * @return string|Subtask
     */
    public function showSubTask(Subtask $subTask)
    {
        try {
            return $subTask->load(['task']);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Summary of deleteSubTask
     * @param \App\Models\Subtask $subTask
     * @throws \Exception
     * @return void
     */
    public function deleteSubTask(Subtask $subTask)
    {
        DB::beginTransaction();
        try {
            $subTask->delete();
            Cache::forget('subTasks_');
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('wrong while delete ' . $e->getMessage());
            throw new \Exception('wrong while deleting this task');
        }
    }
}
