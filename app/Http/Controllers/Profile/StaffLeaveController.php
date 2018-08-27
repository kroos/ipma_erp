<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;

// load model
use App\Model\StaffLeave;

use Illuminate\Http\Request;

// load validation
use App\Http\Requests\StaffLeaveRequest;

use Session;


class StaffLeaveController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
		$this->middleware('leaveaccess', ['only' => ['show', 'edit', 'update']]);
	}

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index()
	{
		return view('leave.index');
		// SELECT leave_no, leave_created_date from `leave` WHERE YEAR(leave_created_date)='2019' ORDER BY leave_id DESC LIMIT 1
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('leave.create');
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request)
	{
		// https://try-carbon.herokuapp.com/?hide-output-gutter&output-left-padding=10&theme=tomorrow_night&border=none&radius=4&v-padding=15&input=%24mutable%20%3D%20Carbon%3A%3Anow()%3B%0A%24immutable%20%3D%20CarbonImmutable%3A%3Anow()%3B%0A%24modifiedMutable%20%3D%20%24mutable-%3Eadd(1%2C%20%27day%27)%3B%0A%24modifiedImmutable%20%3D%20CarbonImmutable%3A%3Anow()-%3Eadd(1%2C%20%27day%27)%3B%0A%0Avar_dump(%24modifiedMutable%20%3D%3D%3D%20%24mutable)%3B%20%20%20%20%20%20%20%20%20%20%20%20%20%2F%2F%20bool(true)%0Avar_dump(%24mutable-%3EisoFormat(%27dddd%20D%27))%3B%20%20%20%20%20%20%20%20%20%20%20%20%20%2F%2F%20string(11)%20%22Saturday%2025%22%0Avar_dump(%24modifiedMutable-%3EisoFormat(%27dddd%20D%27))%3B%20%20%20%20%20%2F%2F%20string(11)%20%22Saturday%2025%22%0A%2F%2F%20So%20it%20means%20%24mutable%20and%20%24modifiedMutable%20are%20the%20same%20object%0A%2F%2F%20both%20set%20to%20now%20%2B%201%20day.%0Avar_dump(%24modifiedImmutable%20%3D%3D%3D%20%24immutable)%3B%20%20%20%20%20%20%20%20%20%2F%2F%20bool(false)%0Avar_dump(%24immutable-%3EisoFormat(%27dddd%20D%27))%3B%20%20%20%20%20%20%20%20%20%20%20%2F%2F%20string(9)%20%22Friday%2024%22%0Avar_dump(%24modifiedImmutable-%3EisoFormat(%27dddd%20D%27))%3B%20%20%20%2F%2F%20string(11)%20%22Saturday%2025%22%0A%2F%2F%20While%20%24immutable%20is%20still%20set%20to%20now%20and%20cannot%20be%20changed%20and%0A%2F%2F%20%24modifiedImmutable%20is%20a%20new%20instance%20created%20from%20%24immutable%0A%2F%2F%20set%20to%20now%20%2B%201%20day.%0A%0A%24mutable%20%3D%20CarbonImmutable%3A%3Anow()-%3EtoMutable()%3B%0Avar_dump(%24mutable-%3EisMutable())%3B%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%2F%2F%20bool(true)%0Avar_dump(%24mutable-%3EisImmutable())%3B%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%2F%2F%20bool(false)%0A%24immutable%20%3D%20Carbon%3A%3Anow()-%3EtoImmutable()%3B%0Avar_dump(%24immutable-%3EisMutable())%3B%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%2F%2F%20bool(false)%0Avar_dump(%24immutable-%3EisImmutable())%3B%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%2F%2F%20bool(true)%0A&token=live-editor-0
		// $fridays = [];
		// $startDate = Carbon::parse('2018-08-01')->next(Carbon::SUNDAY); // Get the first friday.
		// $endDate = Carbon::parse('2018-08-31');
		
		// for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
		//     $fridays[] = $date->format('Y-m-d');
		// }
		// echo count($fridays);

		dd(request());
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show(StaffLeave $staffLeave)
	{
		//
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(StaffLeave $staffLeave)
	{
		//
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, StaffLeave $staffLeave)
	{
		//
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(StaffLeave $staffLeave)
	{
		//
	}
}
