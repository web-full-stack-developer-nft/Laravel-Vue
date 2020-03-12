<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::with([
            'user', 'issue', 'status', 'creator'
        ])->paginate(20);
        return response()->json([
            'tasks' => $tasks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        if ($task = Task::create([
            'task_name' => $request->task_name,
            'user_id' => $request->user_id,
            'issue_id' => $request->issue_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status_id' => $request->status_id,
            'created_by' => auth()->user()->id
        ])) {
            return response()->json([
                'task' => $task
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $task = Task::find($id);
        $task->task_name = $request->task_name;
        $task->user_id = $request->user_id;
        $task->issue_id = $request->issue_id;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->status_id = $request->status_id;

        if ($task->save()) {
            return response()->json([
                'task' => $task
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if ($task->delete()) {
            return response()->json([
                'success' => true
            ]);
        }
    }
}
