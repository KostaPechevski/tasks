<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js" defer></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow mb-6">
        <div class="max-w-4xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('tasks.index') }}" class="text-lg font-semibold text-gray-800">
                Task Management
            </a>
            <div class="space-x-4 text-sm">
                <a href="{{ route('tasks.index') }}" class="text-gray-600 hover:text-gray-900">Tasks</a>
                <a href="{{ route('projects.index') }}" class="text-gray-600 hover:text-gray-900">Projects</a>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4">
        @if (session('status'))
            <div class="mb-4 rounded border border-green-200 bg-green-50 text-green-800 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded border border-red-200 bg-red-50 text-red-800 px-4 py-3 text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>

