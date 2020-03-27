<?php

namespace App\Http\Controllers\Admin;

use App\Models\Issuecomment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class IssuecommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        return Issuecomment::create(
            $request->all()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Issuecomment  $issuecomment
     * @return \Illuminate\Http\Response
     */
    public function show(Issuecomment $issuecomment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Issuecomment  $issuecomment
     * @return \Illuminate\Http\Response
     */
    public function edit(Issuecomment $issuecomment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Issuecomment  $issuecomment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Issuecomment $issuecomment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Issuecomment  $issuecomment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issuecomment $issuecomment)
    {
        //
    }
}
