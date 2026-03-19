@extends('layouts.app')

@section('content')
    <div class="grid gap-6">
        <div class="bg-white rounded shadow p-6">
            <form method="GET" action="{{ route('tasks.index') }}" class="flex items-end gap-4">
                <div>
                    <label for="project_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Project
                    </label>
                    <select id="project_id" name="project_id"
                            class="border rounded px-2 py-1 text-sm">
                        <option value="">All projects</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}"
                                @selected($selectedProjectId == $project->id)>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit"
                            class="inline-flex items-center px-3 py-1.5 text-sm rounded bg-blue-600 text-white hover:bg-blue-700">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Create Task</h2>
            <form method="POST" action="{{ route('tasks.store') }}" class="grid gap-4 md:grid-cols-3 items-end">
                @csrf

                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Task name
                    </label>
                    <input id="name" name="name" type="text" required
                           value="{{ old('name') }}"
                           class="border rounded px-2 py-1.5 text-sm w-full">
                </div>

                <div>
                    <label for="create_project_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Project (optional)
                    </label>
                    <select id="create_project_id" name="project_id"
                            class="border rounded px-2 py-1 text-sm w-full">
                        <option value="">None</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}"
                                @selected(old('project_id', $selectedProjectId) == $project->id)>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-3">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 text-sm rounded bg-green-600 text-white hover:bg-green-700">
                        Add Task
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold">Tasks</h2>
                <p class="text-xs text-gray-500">
                    Drag rows to reorder. Order is saved automatically.
                </p>
            </div>

            @if ($tasks->isEmpty())
                <p class="text-gray-500 text-sm">No tasks to display.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="text-left py-2 px-2 w-10"></th>
                                <th class="text-left py-2 px-2">Name</th>
                                <th class="text-left py-2 px-2">Project</th>
                                <th class="text-left py-2 px-2 w-32">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="task-list">
                            @foreach ($tasks as $task)
                                <tr class="border-b hover:bg-gray-50 cursor-move" data-task-id="{{ $task->id }}">
                                    <td class="py-2 px-2 text-gray-400">⋮⋮</td>
                                    <td class="py-2 px-2 align-top">
                                        <form method="POST"
                                              action="{{ route('tasks.update', $task) }}"
                                              class="flex items-center gap-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="name"
                                                   value="{{ old('name', $task->name) }}"
                                                   class="border rounded px-2 py-1 text-sm w-full">
                                    </td>
                                    <td class="py-2 px-2 align-top">
                                            <select name="project_id"
                                                    class="border rounded px-2 py-1 text-sm w-full">
                                                <option value="">None</option>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}"
                                                        @selected($task->project_id == $project->id)>
                                                        {{ $project->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                    </td>
                                    <td class="py-2 px-2 align-top">
                                            <div class="flex gap-2">
                                                <button type="submit"
                                                        class="px-2 py-1 text-xs rounded bg-blue-600 text-white hover:bg-blue-700">
                                                    Save
                                                </button>
                                        </form>

                                        <form method="POST"
                                              action="{{ route('tasks.destroy', $task) }}"
                                              onsubmit="return confirm('Delete this task?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-2 py-1 text-xs rounded bg-red-600 text-white hover:bg-red-700">
                                                Delete
                                            </button>
                                        </form>
                                            </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const taskList = document.getElementById('task-list');
            if (!taskList || typeof Sortable === 'undefined') {
                return;
            }

            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content');

            new Sortable(taskList, {
                animation: 150,
                handle: 'tr',
                onEnd: function () {
                    const ids = Array.from(taskList.querySelectorAll('tr[data-task-id]'))
                        .map(row => row.getAttribute('data-task-id'));

                    fetch('{{ route('tasks.reorder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ task_ids: ids }),
                    }).then(response => {
                        if (!response.ok) {
                            console.error('Failed to save order');
                        }
                    }).catch(() => {
                        console.error('Failed to save order');
                    });
                }
            });
        });
    </script>
@endsection

