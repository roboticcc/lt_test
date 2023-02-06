<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\V1\TaskCollection;
use App\Http\Resources\V1\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin', ['only' => ['store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(TaskService $service): TaskCollection
    {
        return $service->getTaskSet();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): Response
    {
        $data = $request->validated();
        Task::firstOrCreate($data);

        return \response('New task has been successfuly created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): TaskResource
    {
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task): Response
    {
        $data = $request->validated();
        $task->update($data);
        return \response("Task #$task->id has been successfuly updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): Response
    {
        $task->delete();
        return \response("Successfuly deleted task #$task->id");
    }

    /**
     * Marks given task as completed by current user
     */
    public function submit(Task $task, TaskService $service): Response
    {
        $service->markCompleted($task);
        return response("Task #$task->id has been marked completed");
    }

    /**
     * Replaces given task with a random unassigned one
     */
    public function replace(Task $task, TaskService $service): Response
    {
        $service->replace($task);
        return response("Task #$task->id has been replaced");
    }
}
