<?php

namespace App\Http\Controllers;

use App\Model\StaffEducation;
use Illuminate\Http\Request;

// load validation
use App\Http\Requests\StaffEducationRequest;

use Session;

class StaffEducationController extends Controller
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
		return view('staffEducation.create');
	}
	
	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(StaffEducationRequest $request)
	{
		StaffEducation::create( array_add($request->except(['_method', '_token']), 'staff_id', auth()->user()->belongtostaff->id) );
		Session::flash('flash_message', 'Data successfully created!');
		return redirect( route('staff.show', auth()->user()->belongtostaff->id) );
	}
	
	/**
	* Display the specified resource.
	*
	* @param  \App\StaffEducation  $staffEducation
	* @return \Illuminate\Http\Response
	*/
	public function show(StaffEducation $staffEducation)
	{
	//
	}
	
	/**
	* Show the form for editing the specified resource.
	*
	* @param  \App\StaffEducation  $staffEducation
	* @return \Illuminate\Http\Response
	*/
	public function edit(StaffEducation $staffEducation)
	{
		return view('staffEducation.edit', compact(['staffEducation']));
	}
	
	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  \App\StaffEducation  $staffEducation
	* @return \Illuminate\Http\Response
	*/
	public function update(StaffEducationRequest $request, StaffEducation $staffEducation)
	{
		StaffEducation::where('id', $staffEducation->id)->update($request->except(['_method', '_token']) );

		// info when update success
		Session::flash('flash_message', 'Data successfully edited!');
		return redirect( route('staff.show', auth()->user()->belongtostaff->id) );
	}
	
	/**
	* Remove the specified resource from storage.
	*
	* @param  \App\StaffEducation  $staffEducation
	* @return \Illuminate\Http\Response
	*/
	public function destroy(StaffEducation $staffEducation)
	{
		StaffEducation::destroy($staffEducation->id);

		return response()->json([
									'message' => 'Data deleted',
									'status' => 'success'
								]);
	}
}
