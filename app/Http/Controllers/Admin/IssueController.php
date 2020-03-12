<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Issue;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $issues = Issue::with([
            'issue', 'issue_type', 'status'
        ])->paginate(20);
        return response()->json([
            'issues' => $issues
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIssueRequest $request)
    {
        if ($issue = Issue::create([
            'title' => $request->title,
            'project_id' => $request->project_id,
            'issue_type_id' => $request->issue_type_id,
            'status_id' => $request->status_id,
            'created_by' => auth()->user()->id
        ])) {
            return response()->json([
                'issue' => $issue
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
    public function update(UpdateIssueRequest $request, $id)
    {
        $issue = Issue::find($id);
        $issue->title = $request->title;
        $issue->project_id = $request->project_id;
        $issue->issue_type_id = $request->issue_type_id;
        $issue->status_id = $request->status_id;

        if ($issue->save()) {
            return response()->json([
                'issue' => $issue
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
        $issue = Issue::find($id);
        if ($issue->delete()) {
            return response()->json([
                'success' => true
            ]);
        }
    }
}
