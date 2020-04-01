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
        $task = Task::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'user_id' => $request->issue_id['id'],
            'issue_id' => $request->issue_id['id'],
            'start_date' => date("Y-m-d"),
            'end_date' => date("Y-m-d"),
            'status_id' => 1,
            'created_by' => auth()->user()->id
        ]);
        return $task;
    }

    public function show(Task $task)
    {   
        $task->issue;
        $task->creator;
        foreach ($task->comments as $key => $value) {
            $value->with('user');
        }
        return $task;
    }

    public function task($issue_id='')
    {
         return Task::with('status')->where('issue_id',$issue_id)->get();
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
        $task->name = $request->name;
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
