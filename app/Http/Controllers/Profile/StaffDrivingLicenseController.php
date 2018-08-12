<?php

namespace App\Http\Controllers\Profile;

// to link back from controller original
use App\Http\Controllers\Controller;

use App\Model\StaffDrivingLicense;
use Illuminate\Http\Request;

class StaffDrivingLicenseController extends Controller
{
    // must always refer to php artisan route:list
    function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('admin', ['except' => ['create', 'store']]);
    }
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
     * @param  \App\StaffDrivingLicense  $staffDrivingLicense
     * @return \Illuminate\Http\Response
     */
    public function show(StaffDrivingLicense $staffDrivingLicense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StaffDrivingLicense  $staffDrivingLicense
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffDrivingLicense $staffDrivingLicense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StaffDrivingLicense  $staffDrivingLicense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffDrivingLicense $staffDrivingLicense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StaffDrivingLicense  $staffDrivingLicense
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffDrivingLicense $staffDrivingLicense)
    {
        //
    }
}
