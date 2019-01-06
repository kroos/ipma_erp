<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// load model
use App\Model\ToDoList;

// load validation
use App\Http\Requests\ToDoListUpdateByUserRequest;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Session;

class ToDoListController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('todolist.index');
	}

	public function create()
	{
		//
	}

	public function store(Request $request)
	{
		//
	}

	public function show(ToDoList $todoList)
	{
	//
	}

	public function edit(ToDoList $todoList)
	{
		//
	}

	public function update(Request $request, ToDoList $todoList)
	{
		//
	}

////////////////////////////////////////////////////////
// additional function
	public function updatetask(ToDoListUpdateByUserRequest $request, ToDoList $todoList)
	{
		var_dump($request->all());
		$todoList->update($request->only(['description', 'completed']));
		Session::flash('flash_message', 'Data successfully stored!');
		return redirect( route('todoList.index') );
	}

////////////////////////////////////////////////////////
	public function updatetoggle(Request $request, ToDoList $todoList)
	{
		//
	}

	public function destroy(ToDoList $todoList)
	{
		//
	}
}
