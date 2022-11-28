<?php

namespace App\Services;

use App\Models\Tasks;
use App\Models\User;
use Carbon\Carbon;

class TaskService {

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
        return $tasks;
    }

    public function store($request)
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

    public function update($id, $request)
    {
        $selectedDate = $request['expiration_date'];
        $nowDate = Carbon::now()->startOfDay();

        $result = Carbon::parse($selectedDate)->greaterThanOrEqualTo($nowDate);
        if (!$result) {
            return response()->json([
                'status' => 'error',
                'message' => 'The selected date should be grater or equal to today!'
            ]);
        }

        $task = Tasks::find($id);
        $task->update(['expiration_data' => $request['expiration_date']]);
        return response()->json('Task updated!');
    }

    public function destroy($id)
    {
        $task = Tasks::find($id);
        $task->delete();
        return response()->json('Tasks deleted!');
    }


}
