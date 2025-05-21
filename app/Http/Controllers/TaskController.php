<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskService;
    /**
     * Summary of __construct
     * @param \App\Services\TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService=$taskService;
    }
    /**
     * Summary of index
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
         $filters = $request->only(['title','status','user_id']);
        $perPage = $request->input('per_page', 15);
        $tasks = $this->taskService->listAllTask($filters,$perPage);
        return $this->success($tasks);
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\Task\StoreTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTaskRequest $request)
    {
        $task = $request->validated();
        $this->taskService->createTask($task);
        return $this->success($task,"task created success",201);
    }

    /**
     * Summary of show
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Task $task)
    {
        $task = $this->taskService->showTask($task);
        return $this->success($task);
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\Task\UpdateTaskRequest $request
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $data = $request->validated();
        $this->taskService->updateTask($task,$data);
        return $this->success($task,"task updated success");
    }

    /**
     * Summary of destroy
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task)
    {
        $this->taskService->deleteTask($task);
        return $this->success(null,"deleting success");
    }
}
