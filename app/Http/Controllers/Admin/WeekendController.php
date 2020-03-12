<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Weekend;

class WeekendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weekends = Weekend::paginate(20);
        return response()->json([
            'weekends' => $weekends
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
            'day_name' => 'required',
            'date' => 'required',
        ])->validate();

        if ($weekend = Weekend::create([
            'day_name' => $request->day_name,
            'date' => date('Y-m-d', strtotime($request->date)),
        ])) {
            return response()->json([
                'weekend' => $weekend
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
            'day_name' => 'required',
            'date' => 'required',
        ])->validate();

        $weekend = Weekend::find($id);
        $weekend->day_name = $request->day_name;
        $weekend->date = date('Y-m-d', strtotime($request->date));

        if ($weekend->save()) {
            return response()->json([
                'weekend' => $weekend
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
        $weekend = Weekend::find($id);
        if ($weekend->delete()) {
            return response()->json([
                'success' => true
            ]);
        }
    }
}
