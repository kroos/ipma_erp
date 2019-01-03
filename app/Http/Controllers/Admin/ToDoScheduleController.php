<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// load model
use \App\Model\ToDoSchedule;
use \App\Model\ToDoList;

// load validation
use \App\Http\Requests\ToDoScheduleRequest;

use \Carbon\Carbon;
use \Carbon\CarbonPeriod;

use Session;

class ToDoScheduleController extends Controller
{

	public function index()
	{
		return view('generalAndAdministrative.admin.todolist.index');
	}

	public function create()
	{
		return view('generalAndAdministrative.admin.todolist.create');
	}

	public function store(ToDoScheduleRequest $request)
	{
		// var_dump($request->all());
		// echo $request->category_id.' category id<br />';

		$tds = ToDoSchedule::create( array_add(array_add($request->only(['category_id', 'task', 'description', 'period_reminder', 'dateline', 'priority_id']), 'created_by', \Auth::user()->belongtostaff->id), 'active', 1) );

		if($request->category_id == 1) {
			$d = Carbon::parse($request->dateline);
			$reminder = $d->copy()->subDays($request->period_reminder)->format('Y-m-d');
			$tds->hasonetask()->create( array_add($request->only(['dateline', 'priority_id']), 'reminder', $reminder) );
		}

		// assignee
		if ($request->has('td')) {
			foreach( $request->td as $key => $val ) {
				$tds->hasmanytasker()->create([
					'staff_id' => $val['staff_id']
				]);
			}
		}

		Session::flash('flash_message', 'Data successfully stored!');
		return redirect( route('todoSchedule.index') );
	}

	public function show(ToDoSchedule $todoSchedule)
	{
	//
	}

	public function edit(ToDoSchedule $todoSchedule)
	{
		//
	}

	public function update(ToDoScheduleRequest $request, ToDoSchedule $todoSchedule)
	{
		//
	}

	public function updatetoggle(Request $request, ToDoSchedule $todoSchedule)
	{
		// var_dump ($request->all());
		$todoSchedule->update($request->only(['active']));
		return response()->json([
			'message' => 'Success Enable/Disable Task',
			'status' => 'success'
		]);
	}

	public function destroy(ToDoSchedule $todoSchedule)
	{
		//
	}
}
