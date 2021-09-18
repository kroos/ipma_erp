<?php

namespace App\Http\Controllers\Profile;

// to link back from controller original
use App\Http\Controllers\Controller;

use App\Model\StaffChildren;
use Illuminate\Http\Request;

// load validation
use App\Http\Requests\StaffChildrenRequest;

use Session;

class StaffChildrenController extends Controller
{

    // must always refer to php artisan route:list
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('userchild', ['only' => ['show', 'edit', 'update', 'destroy']]);
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
        return view('staffChildren.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaffChildrenRequest $request)
    {
        StaffChildren::create( Arr::add( $request->except(['_method', '_token']), 'staff_id', auth()->user()->belongtostaff->id) );

        Session::flash('flash_message', 'Data successfully edited!');
        return redirect( route('staff.show', auth()->user()->belongtostaff->id) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StaffChildren  $staffChildren
     * @return \Illuminate\Http\Response
     */
    public function show(StaffChildren $staffChild)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StaffChildren  $staffChildren
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffChildren $staffChild)
    {
        return view('staffChildren.edit', compact(['staffChild']) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StaffChildren  $staffChildren
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffChildren $staffChild)
    {
        StaffChildren::where('id', $staffChild->id)->update($request->except(['_method', '_token']) );

        // info when update success
        Session::flash('flash_message', 'Data successfully edited!');
        return redirect( route('staff.show', auth()->user()->belongtostaff->id) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StaffChildren  $staffChildren
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffChildren $staffChild)
    {
        StaffChildren::destroy($staffChild->id);
        return response()->json([
                                    'message' => 'Data deleted',
                                    'status' => 'success'
                                ]);
    }
}
