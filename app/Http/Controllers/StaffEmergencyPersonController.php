<?php

namespace App\Http\Controllers;

use App\Model\StaffEmergencyPerson;
use Illuminate\Http\Request;

class StaffEmergencyPersonController extends Controller
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
		//
	}
	
	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  \App\StaffEmergencyPerson  $staffEmergencyPerson
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, StaffEmergencyPerson $staffEmergencyPerson)
	{
		//
	}
	
	/**
	* Remove the specified resource from storage.
	*
	* @param  \App\StaffEmergencyPerson  $staffEmergencyPerson
	* @return \Illuminate\Http\Response
	*/
	public function destroy(StaffEmergencyPerson $staffEmergencyPerson)
	{
		//
	}
}
