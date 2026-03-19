<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskReorderRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Project;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService $taskService,
    ) {
    }
    public function index(Request $request)
    {
        $projects = Project::orderBy('name')->get();
        $selectedProjectId = $request->query('project_id');

        $tasksQuery = Task::query()->with('project')->ordered();

        if ($selectedProjectId) {
            $tasksQuery->where('project_id', $selectedProjectId);
        }

        $tasks = $tasksQuery->get();

        return view('tasks.index', compact('tasks', 'projects', 'selectedProjectId'));
    }

    public function store(TaskStoreRequest $request)
    {
        $data = $request->validated();
        $projectId = $data['project_id'] ?? null;

        $this->taskService->createTask(
            name: $data['name'],
            projectId: $projectId,
        );

        return redirect()
            ->route('tasks.index', ['project_id' => $projectId])
            ->with('status', 'Task created successfully.');
    }

    public function update(TaskUpdateRequest $request, Task $task)
    {
        $data = $request->validated();
        $projectId = $data['project_id'] ?? null;

        $this->taskService->updateTask(
            task: $task,
            name: $data['name'],
            projectId: $projectId,
        );

        return redirect()
            ->route('tasks.index', ['project_id' => $task->project_id])
            ->with('status', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $projectId = $task->project_id;

        $this->taskService->deleteTask($task);

        return redirect()
            ->route('tasks.index', ['project_id' => $projectId])
            ->with('status', 'Task deleted successfully.');
    }

    public function reorder(TaskReorderRequest $request)
    {
        $taskIds = $request->validated()['task_ids'];

        $this->taskService->reorderTasks($taskIds);

        return response()->json([
            'status' => 'ok',
        ]);
    }

}

