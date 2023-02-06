<?php

namespace App\Services;

use App\Http\Resources\V1\TaskCollection;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;

class TaskService
{
    private mixed $currentUserTaskList;
    private Authenticatable $user;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->currentUserTaskList = Task::where('assigned_to', $this->user->id)->get();
    }

    /**
     * Returns collection of tasks for current user
     */
    public function getTaskSet(): TaskCollection
    {
        if (sizeof($this->currentUserTaskList) === 0) {
            $this->currentUserTaskList = Task::where('assigned_to', null)
                ->take(10)
                ->update(['assigned_to' => $this->user->id]);
        }

        return new TaskCollection($this->currentUserTaskList);
    }

    /**
     * Replaces given task with a random unassigned one
     * Replaced task becomes unassigned and open for assigning to other users
     */
    public function replace(Task $task): void
    {
        $task->update(['assigned_to' => null]);

        $freeTask = DB::table('tasks')
            ->where('assigned_to', '=', null)
            ->inRandomOrder()
            ->limit(1);
        $freeTask->update(['assigned_to' => $this->user->id]);
    }

    /**
     * Marks given task as completed by current user
     */
    public function markCompleted(Task $task): void
    {
        $task->userCompleted()->syncWithoutDetaching([$this->user->id]);
    }
}
