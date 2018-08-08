<?php

namespace App\Http\Controllers;

use App\Model\StaffSibling;
use Illuminate\Http\Request;

// load validation
use App\Http\Requests\StaffSiblingRequest;
use App\Http\Requests\StaffSiblingEditRequest;

use Session;

class StaffSiblingController extends Controller
{
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
        return view('staffSibling.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->staff as $key => $val)
        {
            StaffSibling::create( array_add($val, 'staff_id', auth()->user()->belongtostaff->id) );
        }
        Session::flash('flash_message', 'Data successfully edited!');
        return redirect( route('staff.show', auth()->user()->belongtostaff->id) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StaffSibling  $staffSibling
     * @return \Illuminate\Http\Response
     */
    public function show(StaffSibling $staffSibling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StaffSibling  $staffSibling
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffSibling $staffSibling)
    {
        return view('staffSibling.edit', compact(['staffSpouse']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StaffSibling  $staffSibling
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffSibling $staffSibling)
    {
        StaffSibling::where('id', $staffSibling->id)->update($request->except(['_method', '_token']) );

        // info when update success
        Session::flash('flash_message', 'Data successfully edited!');
        return redirect( route('staff.show', auth()->user()->belongtostaff->id) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StaffSibling  $staffSibling
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffSibling $staffSibling)
    {
        StaffSibling::destroy($staffSibling->id);
        return response()->json([
                                    'message' => 'Data deleted',
                                    'status' => 'success'
                                ]);
    }
}
