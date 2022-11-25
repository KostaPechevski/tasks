<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index()
    {
        if(auth()->user()->id == User::USER) {
            $tasks = Tasks::where('user_id', User::USER)
                ->with('user')
                ->orderBy('expiration_data', 'desc')
                ->get()
                ->toArray();
        } else {
            $tasks = Tasks::with('user')
                ->orderBy('expiration_data', 'desc')
                ->get()
                ->toArray();
        }
        return ($tasks);
    }

    public function store(StoreTaskRequest $request)
    {

        $task = new Tasks([
            'title' => $request->input('title'),
            'expiration_data' => $request->input('expiration_data'),
            'description' => $request->input('description'),
            'state' => $request->input('state'),
            'user_id' => auth()->user()->id
        ]);
        $task->save();
        return response()->json('Task created!');
    }

    public function update($id, Request $request)
    {
        $task = Tasks::find($id);
        $task->update(['expiration_data' => $request['expiration_date']]);
        return response()->json('Tasks updated!');
    }

    public function destroy($id)
    {
        $task = Tasks::find($id);
        $task->delete();
        return response()->json('Tasks deleted!');
    }
}
