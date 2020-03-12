<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Notice;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notices = Notice::paginate(20);
        return response()->json([
            'notices' => $notices
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
            'title' => 'required',
            'desc' => 'required',
            'publish_at' => 'required',
        ])->validate();

        if ($notice = Notice::create([
            'title' => $request->title,
            'desc' => $request->desc,
            'publish_at' => date('Y-m-d H:i:s', strtotime($request->publish_at)),
        ])) {
            return response()->json([
                'notice' => $notice
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
            'title' => 'required',
            'desc' => 'required',
            'publish_at' => 'required',
        ])->validate();

        $notice = Notice::find($id);
        $notice->title = $request->title;
        $notice->desc = $request->desc;
        $notice->publish_at = date('Y-m-d H:i:s', strtotime($request->publish_at));

        if ($notice->save()) {
            return response()->json([
                'notice' => $notice
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
        $notice = Notice::find($id);
        if ($notice->delete()) {
            return response()->json([
                'success' => true
            ]);
        }
    }
}
