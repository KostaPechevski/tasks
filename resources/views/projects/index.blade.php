@extends('layouts.app')

@section('content')
    <div class="bg-white rounded shadow p-6">
        <h1 class="text-xl font-semibold mb-4">Projects</h1>

        @if ($projects->isEmpty())
            <p class="text-gray-500 text-sm">No projects created yet.</p>
        @else
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2 px-2">ID</th>
                        <th class="text-left py-2 px-2">Name</th>
                        <th class="text-left py-2 px-2">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-2">{{ $project->id }}</td>
                            <td class="py-2 px-2">
                                <a href="{{ route('tasks.index', ['project_id' => $project->id]) }}"
                                   class="text-blue-600 hover:underline">
                                    {{ $project->name }}
                                </a>
                            </td>
                            <td class="py-2 px-2 text-gray-500">
                                {{ $project->created_at->format('Y-m-d H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

