<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// load model
use App\Model\ToDoList;
use App\Model\ToDoStaff;

// load validation
use App\Http\Requests\ToDoListUpdateByUserRequest;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Session;

// load calendar
use Calendar;

class ToDoListController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$events = [];
		$data = ToDoStaff::where('staff_id', \Auth::user()->belongtostaff->id)->get();
		// echo $data->count();
		// die();
		if ($data->count()) {

			foreach ($data as $key) {
				foreach( $key->belongtoschedule->hasmanytask()->whereDate('reminder', '<=', today())->whereNull('completed')->get() as $ke ) {
					// echo  $ke->dateline.'<br />';

					switch ($key->belongtoschedule->belongtopriority->id) {
						case '3':
							$prio = '#c8c8c8';
							break;

						case '2':
							$prio = '#ffeeba';
							break;

						case '1':
							$prio = '#f5c6cb';
							break;

						default:
							$prio = '#ffffff';
							break;
					}

					$events[] = Calendar::event(
						$key->belongtoschedule->task,		// event title
						true,								// full day event?
						$ke->dateline,						// start time
						$ke->dateline,						// end time
						$key->id,							// id of the event (optional)
						// optional
						[
							'color' => $prio,
							'url' => route('todoList.edit', $key->id),
							'textColor' => 'blue',
							// 'backgroundColor' => 'grey',
							'description' => $key->belongtoschedule->description,
						]
					);
				}
			}

		}

		$calendar = \Calendar::addEvents($events)
				->setCallbacks([ // somehow callbacks not working
					// 'eventRender' => 'function(event, element) {
					// 	element.popover({
					// 			title: event.title,
					// 			content: event.description,
					// 			trigger: \'hover\',
					// 			placement: \'top\',
					// 			container: \'body\',
					// 		});
					// }'
				]);

		return view('todolist.index', compact('calendar'));
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
		return view('todolist.edit', compact('todoList'));
	}

	public function update(ToDoListUpdateByUserRequest $request, ToDoList $todoList)
	{
		$todoList->update( Arr::add($request->only(['description', 'completed']), 'update_by', \Auth::user()->belongtostaff->id) );
		Session::flash('flash_message', 'Data successfully updated!');
		return redirect( route('todoList.index') );
	}

////////////////////////////////////////////////////////
// additional function
	public function updatetask(ToDoListUpdateByUserRequest $request, ToDoList $todoList)
	{
		// var_dump($request->all());
		$todoList->update( Arr::add($request->only(['description', 'completed']), 'update_by', \Auth::user()->belongtostaff->id) );
		Session::flash('flash_message', 'Data successfully stored!');
		return redirect( route('todoList.index') );
	}

	public function updatetoggle(Request $request, ToDoList $todoList)
	{
		//
	}

////////////////////////////////////////////////////////

	public function destroy(ToDoList $todoList)
	{
		//
	}
}
