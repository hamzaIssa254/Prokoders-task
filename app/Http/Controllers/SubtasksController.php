<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Models\subtasks;
use Illuminate\Http\Request;
use App\Services\SubTaskService;
use App\Http\Requests\SubTask\StoreSubTaskRequest;
use App\Http\Requests\SubTask\UpdateSubTaskRequest;

class SubtasksController extends Controller
{
    protected $subTasService;
    /**
     * Summary of __construct
     * @param \App\Services\SubTaskService $subTaskService
     */
    public function __construct(SubTaskService $subTaskService)
    {
        $this->subTasService = $subTaskService;
    }
    /**
     * Summary of index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $perPage = request('per_page', 10);
        $subTask = $this->subTasService->listAllSubTask($perPage);
        return $this->success($subTask);
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\SubTask\StoreSubTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreSubTaskRequest $request)
    {
        $data = $request->validated();
        $subTask = $this->subTasService->createSubTask($data);
        return $this->success($subTask,"subtask created success");
    }

    /**
     * Summary of show
     * @param \App\Models\Subtask $subtask
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Subtask $subtask)
    {
        $subtask = $this->subTasService->showSubTask($subtask);
        return $this->success($subtask,"subtask retreive success");
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\SubTask\UpdateSubTaskRequest $request
     * @param \App\Models\Subtask $subtask
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSubTaskRequest $request, Subtask $subtask)
    {
        $data = $request->validated();
        $subtask = $this->subTasService->updateSubTask($subtask,$data);
         return $this->success($subtask,"subtask updated success");

    }

    /**
     * Summary of destroy
     * @param \App\Models\Subtask $subtask
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Subtask $subtask)
    {
        $this->subTasService->deleteSubTask($subtask);
         return $this->success(null,"subtask deleted success");

    }
}
