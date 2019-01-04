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

class ToDoListController extends Controller
{

	public function index()
	{
		return view('todolist.index');
	}

	public function create()
	{
		//
	}

	public function store(ToDoScheduleRequest $request)
	{
		//
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
		//
	}

	public function destroy(ToDoSchedule $todoSchedule)
	{
		//
	}
}
