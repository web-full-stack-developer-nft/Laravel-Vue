<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Attendance;
use Auth;
class AdminController extends Controller
{
    public function attendances($value='')
    {
        $user=User::all();
        $attendance=Attendance::where('date',date("Y-m-d"))->where('user_id',Auth::id())->get()->first();
        return response()->json([
            'user' => $user,
            'attendance' => $attendance
        ]);
    }

    public function checkIn(Request $r)
    {
    	if ($attendance = Attendance::create($r->all())) {
            return response()->json([
                'attendance' => $attendance
            ]);
        }
    }

    public function attendancesUpdate($id)
    {
    	$attendance=Attendance::find($id);
    	$attendance->out_time=date("h:i a");
    	if ($attendance->update()) {
            return response()->json([
                'success' => true
            ]);
        }
    }
}
