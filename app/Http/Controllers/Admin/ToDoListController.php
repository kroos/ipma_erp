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
		$data = $st = ToDoStaff::where('staff_id', \Auth::user()->belongtostaff->id)->get();
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
						// Carbon::now()->format('Y-m-d'),		// start time
						$ke->dateline,		// start time
						$ke->dateline,						// end time
						$key->id,							// id of the event (optional)
						// optional
						[
							'color' => $prio,
							// 'url' => 'pass here url and any route',
						]
					);
				}
			}

		}
		$calendar = Calendar::addEvents($events);
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
		$todoList->update( array_add($request->only(['description', 'completed']), 'updated_by', \Auth::user()->belongtostaff->id) );
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
