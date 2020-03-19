<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Status;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class StatusController extends Controller
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
        
        $query = Status::eloquentQuery($sortBy, $orderBy, $searchValue);

        $data = $query->paginate($length);
        return new DataTableCollectionResource($data);
    }

    public function create()
    {
        $status=new Status();
        return response($status->getTableColumns());
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

        if ($status = Status::create([
            'name' => $request->name,
        ])) {
            return response()->json([
                'status' => $status
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

        $status = Status::find($id);
        $status->name = $request->name;

        if ($status->save()) {
            return response()->json([
                'status' => $status
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
        $status = Status::find($id);
        if ($status->delete()) {
            return response()->json([
                'success' => true
            ]);
        }
    }
}
