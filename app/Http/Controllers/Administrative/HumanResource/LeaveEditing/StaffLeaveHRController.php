<?php

namespace App\Http\Controllers\Administrative\HumanResource\LeaveEditing;

use App\Http\Controllers\Controller;

use App\Model\StaffLeave;
use Illuminate\Http\Request;

class StaffLeaveHRController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\StaffLeave  $staffLeave
     * @return \Illuminate\Http\Response
     */
    public function show(StaffLeave $staffLeaveHR)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\StaffLeave  $staffLeave
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffLeave $staffLeaveHR)
    {
        return view('generalAndAdministrative.hr.leave.leavelist.edit', compact(['staffLeaveHR']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\StaffLeave  $staffLeave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffLeave $staffLeaveHR)
    {
        print_r ($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\StaffLeave  $staffLeave
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffLeave $staffLeaveHR)
    {
        //
    }
}
