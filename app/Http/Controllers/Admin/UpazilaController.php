<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Upazila;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class UpazilaController extends Controller
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
        
        $query = Upazila::eloquentQuery(
            $sortBy, 
            $orderBy, 
            $searchValue, [
                'district',
                'name',
                'status',
            ]);

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
            'name' => 'required',
            'district_id' => 'required',
        ])->validate();

        if ($upazila = Upazila::create([
            'name' => $request->name,
            'district_id' => $request->district_id,
        ])) {
            return response()->json([
                'upazila' => $upazila
            ]);
        }
    }

    public function create()
    {
        $upazila=new Upazila();
        return response($upazila->getTableColumns());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
            'district_id' => 'required',
        ])->validate();

        $upazila = Upazila::find($id);
        $upazila->name = $request->name;
        $upazila->district_id = $request->district_id;

        if ($upazila->save()) {
            return response()->json([
                'upazila' => $upazila
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
        $upazila = Upazila::find($id);
        if ($upazila->delete()) {
            return response()->json([
                'success' => true
            ]);
        }
    }
}
