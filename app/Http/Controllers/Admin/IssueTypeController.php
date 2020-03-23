<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\IssueType;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class IssueTypeController extends Controller
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
        
        $query = IssueType::eloquentQuery($sortBy, $orderBy, $searchValue);

        $data = $query->paginate($length);
        return new DataTableCollectionResource($data);
    }

    public function all(Request $request)
    {
        $issue_types;
        if ($request->has('status')) {
            $issue_types = IssueType::where('status', $request->input('status'))->get();
        }else {
            $issue_types = IssueType::get();
        }

        return \response()->json($issue_types);
    }

    public function create()
    {
        $issueType=new IssueType();
        return response($issueType->getTableColumns());
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
