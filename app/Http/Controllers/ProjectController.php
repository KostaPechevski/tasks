<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('name')->get();

        return view('projects.index', compact('projects'));
    }
}

