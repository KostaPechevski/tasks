<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public function createTask(string $name, ?int $projectId): Task
    {
        $nextPriority = Task::where('project_id', $projectId)->max('priority') ?? 0;

        return Task::create([
            'name' => $name,
            'project_id' => $projectId,
            'priority' => $nextPriority + 1,
        ]);
    }

    public function updateTask(Task $task, string $name, ?int $projectId): void
    {
        $oldProjectId = $task->project_id;
        $newProjectId = $projectId;

        DB::transaction(function () use ($task, $name, $oldProjectId, $newProjectId) {
            $task->name = $name;

            if ($oldProjectId !== $newProjectId) {
                $task->project_id = $newProjectId;
                $task->priority = (Task::where('project_id', $newProjectId)->max('priority') ?? 0) + 1;

                $task->save();

                $this->resequenceProjectTasks($oldProjectId);
            } else {
                $task->save();
            }
        });
    }

    public function deleteTask(Task $task): void
    {
        $projectId = $task->project_id;

        DB::transaction(function () use ($task, $projectId) {
            $task->delete();
            $this->resequenceProjectTasks($projectId);
        });
    }

    public function reorderTasks(array $taskIds): void
    {
        DB::transaction(function () use ($taskIds) {
            foreach ($taskIds as $index => $taskId) {
                Task::whereKey($taskId)->update([
                    'priority' => $index + 1,
                ]);
            }
        });
    }

    protected function resequenceProjectTasks(?int $projectId): void
    {
        $tasks = Task::where('project_id', $projectId)
            ->ordered()
            ->get();

        foreach ($tasks as $index => $task) {
            $task->update(['priority' => $index + 1]);
        }
    }
}

