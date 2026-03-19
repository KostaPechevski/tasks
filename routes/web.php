<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::get('/projects', [ProjectController::class, 'index'])
    ->name('projects.index');

Route::get('/tasks', [TaskController::class, 'index'])
    ->name('tasks.index');

Route::post('/tasks/store', [TaskController::class, 'store'])
    ->name('tasks.store');

Route::put('/tasks/{task}/update', [TaskController::class, 'update'])
    ->name('tasks.update');

Route::delete('/tasks/{task}/delete', [TaskController::class, 'destroy'])
    ->name('tasks.destroy');

Route::post('/tasks/reorder', [TaskController::class, 'reorder'])
    ->name('tasks.reorder');

