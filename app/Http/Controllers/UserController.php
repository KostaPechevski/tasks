<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function getUserTasks($username) {
        $userTasks = User::with('tasks')->where('username', $username)->get();

        foreach ($userTasks as $userTask) {
            return json_encode($userTask->tasks);
        }
    }
}
