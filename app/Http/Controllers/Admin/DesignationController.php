<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Designation;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class DesignationController extends Controller
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
        
        $query = Designation::eloquentQuery($sortBy, $orderBy, $searchValue);

        $data = $query->paginate($length);
        return new DataTableCollectionResource($data);
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

        if ($designation = Designation::create([
            'name' => $request->name,
        ])) {
            return response()->json([
                'designation' => $designation
            ]);
        }
    }

    public function create()
    {
        $designation=new Designation();
        return response($designation->getTableColumns());
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

        $designation = Designation::find($id);
        $designation->name = $request->name;

        if ($designation->save()) {
            return response()->json([
                'designation' => $designation
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
        $designation = Designation::find($id);
        if ($designation->delete()) {
            return response()->json([
                'success' => true
            ]);
        }
    }
}
