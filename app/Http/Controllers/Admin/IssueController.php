<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Issue;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');
        
        $query = Issue::eloquentQuery(
            $sortBy, 
            $orderBy, 
            $searchValue, [
                'project',
                'client',
                'department',
                'issue_type',
                'user',
                'status',
            ]);

        $data = $query->paginate($length);
        return new DataTableCollectionResource($data);
    }

    public function create()
    {
        $issue=new Issue();
        return response($issue->getTableColumns());
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
            'client_id' => $request->client_id,
            'project_id' => $request->project_id,
            'department_id' => $request->department_id,
            'issue_type_id' => $request->issue_type_id,
            'status_id' => 1,
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
        $issue->client_id = $request->client_id;
        $issue->department_id = $request->department_id;
        $issue->desc = $request->desc;
        $issue->issue_type_id = $request->issue_type_id;
        $issue->status_id = $request->status_id;
        $issue->updated_at = date('Y-m-d H:i:s');

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
