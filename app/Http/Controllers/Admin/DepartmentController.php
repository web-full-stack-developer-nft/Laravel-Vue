<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Department;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class DepartmentController extends Controller
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
        
        $query = Department::eloquentQuery($sortBy, $orderBy, $searchValue);

        $data = $query->paginate($length);
        
        return new DataTableCollectionResource($data);
    }

    public function all(Request $request)
    {
        $departments;
        if ($request->has('status')) {
            $departments = Department::where('status', $request->input('status'))->get();
        }else {
            $departments = Department::get();
        }

        return \response()->json($departments);
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
            'name' => 'required'
        ])->validate();

        if ($department = Department::create([
            'name' => $request->name,
        ])) {
            return response()->json([
                'department' => $department
            ]);
        }
    }

    public function create()
    {
        $department=new Department();
        return response($department->getTableColumns());
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
            'name' => 'required'
        ])->validate();

        $department = Department::find($id);
        $department->name = $request->name;

        if ($department->save()) {
            return response()->json([
                'department' => $department
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
        $department = Department::find($id);
        if ($department->delete()) {
            return response()->json([
                'success' => true
            ]);
        }
    }
}
