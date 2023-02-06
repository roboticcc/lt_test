<?php

namespace App\Http\Resources\V1;

use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'category' => $this->category->title,
            'completed' => $this->checkIfCompleted(),
        ];
    }

    /**
     * Checks if current user has completed the task
     */
    private function checkIfCompleted(): string
    {
        $currentUserId = auth()->user()->id;

        if (isset($this->userCompleted[0]->id) && $this->userCompleted[0]->id === $currentUserId) {
            return 'true';
        }

        return 'false';
    }
}
