<?php

namespace App\Http\Controllers\Locker;

use App\Http\Controllers\Controller;

use App\Model\LockerStatus;
use Illuminate\Http\Request;

class LockerStatusController extends Controller
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
     * @param  \App\LockerStatus  $lockerStatus
     * @return \Illuminate\Http\Response
     */
    public function show(LockerStatus $lockerStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LockerStatus  $lockerStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(LockerStatus $lockerStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LockerStatus  $lockerStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LockerStatus $lockerStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LockerStatus  $lockerStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(LockerStatus $lockerStatus)
    {
        //
    }
}
