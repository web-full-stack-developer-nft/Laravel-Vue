<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = Attendance::paginate(20);
        return response()->json([
            'attendances' => $attendances
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
            'user_id' => 'required',
        ])->validate();

        if ($attendance = Attendance::create([
            'user_id' => auth()->user()->id,
        ])) {
            return response()->json([
                'attendance' => $attendance
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
            'user_id' => 'required',
        ])->validate();

        $attendance = Attendance::find($id);
        $attendance->user_id = auth()->user()->id;

        if ($attendance->save()) {
            return response()->json([
                'attendance' => $attendance
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
        $attendance = Attendance::find($id);
        if ($attendance->delete()) {
            return response()->json([
                'success' => true
            ]);
        }
    }
}
