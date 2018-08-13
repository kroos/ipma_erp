<?php

namespace App\Http\Controllers\Profile;

// to link back from controller original
use App\Http\Controllers\Controller;

use App\Model\StaffEmergencyPersonPhone;
use Illuminate\Http\Request;

// load validation
use App\Http\Requests\StaffEmergencyPersonPhoneRequest;

use Session;

class StaffEmergencyPersonPhoneController extends Controller
{
    // must always refer to php artisan route:list
    
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('useremergencyphone', ['except' => ['create', 'store']]);
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
    public function store(StaffEmergencyPersonPhoneRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StaffEmergencyPersonPhone  $staffEmergencyPersonPhone
     * @return \Illuminate\Http\Response
     */
    public function show(StaffEmergencyPersonPhone $staffEmergencyPersonPhone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StaffEmergencyPersonPhone  $staffEmergencyPersonPhone
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffEmergencyPersonPhone $staffEmergencyPersonPhone)
    {
        return view('staffEmergencyPersonPhone.edit', compact(['staffEmergencyPersonPhone']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StaffEmergencyPersonPhone  $staffEmergencyPersonPhone
     * @return \Illuminate\Http\Response
     */
    public function update(StaffEmergencyPersonPhoneRequest $request, StaffEmergencyPersonPhone $staffEmergencyPersonPhone)
    {
        StaffEmergencyPersonPhone::where('id', $staffEmergencyPersonPhone->id)->update($request->except(['_method', '_token']));

        // info when update success
        Session::flash('flash_message', 'Data successfully edited!');
        return redirect( route('staff.show', auth()->user()->belongtostaff->id) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StaffEmergencyPersonPhone  $staffEmergencyPersonPhone
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffEmergencyPersonPhone $staffEmergencyPersonPhone)
    {
        StaffEmergencyPersonPhone::destroy($staffEmergencyPersonPhone->id);
        return response()->json([
                                    'message' => 'Data deleted',
                                    'status' => 'success'
                                ]);
    }

    public function search(Request $request)
    {
        foreach ($request->emerg as $key => $value) {
            $valid = TRUE;
            $phone = StaffEmergencyPersonPhone::where('phone', $value['phone'])->count();
            if ($phone == 1) 
            {
                $valid = FALSE;
            }
            return response()->json(['valid' => $valid]);
        }
    }

}
