<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\IssueType;

class IssueTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $issue_types = IssueType::paginate(20);
        return response()->json([
            'issue_types' => $issue_types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
        ])->validate();

        if ($issue_type = IssueType::create([
            'name' => $request->name,
        ])) {
            return response()->json([
                'issue_type' => $issue_type
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
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'name' => 'required',
        ])->validate();

        $issue_type = IssueType::find($id);
        $issue_type->name = $request->name;

        if ($issue_type->save()) {
            return response()->json([
                'issue_type' => $issue_type
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
        $issue_type = IssueType::find($id);
        if ($issue_type->delete()) {
            return response()->json([
                'success' => true
            ]);
        }
    }
}
