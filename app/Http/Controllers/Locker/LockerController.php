<?php

namespace App\Http\Controllers\Locker;

use App\Http\Controllers\Controller;

use App\Model\Locker;
use Illuminate\Http\Request;

class LockerController extends Controller
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
     * @param  \App\Locker  $locker
     * @return \Illuminate\Http\Response
     */
    public function show(Locker $locker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Locker  $locker
     * @return \Illuminate\Http\Response
     */
    public function edit(Locker $locker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Locker  $locker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Locker $locker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Locker  $locker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Locker $locker)
    {
        //
    }
}
