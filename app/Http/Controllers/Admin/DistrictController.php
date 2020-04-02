<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\District;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class DistrictController extends Controller
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
        
        $query = District::eloquentQuery($sortBy, $orderBy, $searchValue);

        $data = $query->paginate($length);
        
        return new DataTableCollectionResource($data);
    }

    public function all(Request $request)
    {
        $districts;
        if ($request->has('status')) {
            $districts = District::where('status', $request->input('status'))->get();
        }else {
            $districts = District::get();
        }

        return \response()->json($districts);
    }

    public function create()
    {
        $district=new District();
        return response($district->getTableColumns());
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

        if ($district = District::create([
            'name' => $request->name,
        ])) {
            return response()->json([
                'district' => $district
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        $district = District::find($id);
        $district->name = $request->name;

        if ($district->save()) {
            return response()->json([
                'district' => $district
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
        $district = District::find($id);
        if ($district->delete()) {
            return response()->json([
                'success' => true
            ]);
        }
    }
}
