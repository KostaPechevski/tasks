<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TasksController extends Controller

{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        return $this->taskService->index();
    }

    public function store(StoreTaskRequest $request)
    {
        return $this->taskService->store($request);
    }

    public function update($id, Request $request)
    {
        return $this->taskService->update($id, $request);
    }

    public function destroy($id)
    {
        return $this->taskService->destroy($id);
    }
}
