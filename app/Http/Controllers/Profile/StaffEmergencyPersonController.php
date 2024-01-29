<?php

namespace App\Http\Controllers\Profile;

// to link back from controller original
use App\Http\Controllers\Controller;

// load model
use App\Model\StaffEmergencyPerson;
use App\Model\StaffEmergencyPersonPhone;

use Illuminate\Http\Request;

// load validation
use App\Http\Requests\StaffEmergencyPersonRequest;

use Session;

class StaffEmergencyPersonController extends Controller
{
	// must always refer to php artisan route:list
	
	function __construct()
	{
		$this->middleware('auth');
		$this->middleware('useremergencyperson', ['except' => ['create', 'store']]);
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
		return view('staffEmergencyPerson.create');
	}
	
	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(StaffEmergencyPersonRequest $request)
	{
		// dd($request->except(['_method', '_token', 'emerg']));

		$emergency = StaffEmergencyPerson::create( array_add($request->except(['_method', '_token', 'emerg']), 'staff_id', auth()->user()->belongtostaff->id) );

        foreach ($request->emerg as $key => $val) {
            StaffEmergencyPersonPhone::create( array_add($val, 'emergency_person_id', $emergency->id) );
        }

        Session::flash('flash_message', 'Data successfully edited!');
        return redirect( route('staff.show', auth()->user()->belongtostaff->id) );
	}
	
	/**
	* Display the specified resource.
	*
	* @param  \App\StaffEmergencyPerson  $staffEmergencyPerson
	* @return \Illuminate\Http\Response
	*/
	public function show(StaffEmergencyPerson $staffEmergencyPerson)
	{
		//
	}
	
	/**
	* Show the form for editing the specified resource.
	*
	* @param  \App\StaffEmergencyPerson  $staffEmergencyPerson
	* @return \Illuminate\Http\Response
	*/
	public function edit(StaffEmergencyPerson $staffEmergencyPerson)
	{
		return view('staffEmergencyPerson.edit', compact(['staffEmergencyPerson']));
	}
	
	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  \App\StaffEmergencyPerson  $staffEmergencyPerson
	* @return \Illuminate\Http\Response
	*/
	public function update(StaffEmergencyPersonRequest $request, StaffEmergencyPerson $staffEmergencyPerson)
	{
		StaffEmergencyPerson::where('id', $staffEmergencyPerson->id)->update($request->except(['_method', '_token']) );

		// info when update success
		Session::flash('flash_message', 'Data successfully edited!');
		return redirect( route('staff.show', auth()->user()->belongtostaff->id) );
	}
	
	/**
	* Remove the specified resource from storage.
	*
	* @param  \App\StaffEmergencyPerson  $staffEmergencyPerson
	* @return \Illuminate\Http\Response
	*/
	public function destroy(StaffEmergencyPerson $staffEmergencyPerson)
	{
		// StaffEmergencyPerson::destroy($staffEmergencyPerson->id);

		$sale = StaffEmergencyPerson::find($staffEmergencyPerson->id);
		// Sales::destroy($sales->id);
		$sale->hasmanyemergencypersonphone()->delete();
		$sale->delete();

		return response()->json([
									'message' => 'Data deleted',
									'status' => 'success'
								]);
	}
}
