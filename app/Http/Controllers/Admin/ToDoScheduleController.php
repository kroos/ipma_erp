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

// load calendar
use Calendar;

use Session;

class ToDoScheduleController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
		$this->middleware('officeaccess');
	}

	public function index()
	{
		$events = [];
		$data = \Auth::user()->belongtostaff->hasmanytaskcreator()->where('active', 1)->get();
		if ($data->count()) {

			foreach ($data as $key) {

				switch ($key->belongtopriority->id) {
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
					$key->task,		// event title
					true,			// full day event?
					$key->dateline,	// start time
					$key->dateline,	// end time
					$key->id,		// id of the event (optional)
					// optional
					[
						'color' => $prio,
						// 'url' => 'pass here url and any route',
						'description' => $key->description,
					]
				);
			}
		}
		$calendar = \Calendar::addEvents($events)
				->setCallbacks([
					// 'viewRender' => 'function(event, element) {element.popover({title: event.title,content: event.description,trigger: \'hover\',placement: \'top\',container: \'body\'});}'
				]);

		return view('generalAndAdministrative.admin.todolist.index', compact(['calendar']));
	}

	public function create()
	{
		return view('generalAndAdministrative.admin.todolist.create');
	}

	public function store(ToDoScheduleRequest $request)
	{
		// var_dump($request->all());
		// echo $request->category_id.' category id<br />';

		$tds = ToDoSchedule::create( Arr::add(Arr::add($request->only(['category_id', 'task', 'description', 'period_reminder', 'dateline', 'priority_id']), 'created_by', \Auth::user()->belongtostaff->id), 'active', 1) );

		// getting the reminder
		$d = Carbon::parse($request->dateline);

		if($request->category_id == 1) {					// 1 time off

			$reminder = $d->copy()->subDays($request->period_reminder)->format('Y-m-d');
		} elseif ($request->category_id == 3) {				// monthly

			$reminder = $d->copy()->subDays($request->period_reminder)->format('Y-m-d');
		} elseif ($request->category_id == 6) {				// yearly

			$reminder = $d->copy()->subDays($request->period_reminder)->format('Y-m-d');
		}

		$tds->hasmanytask()->create( Arr::add($request->only(['dateline', 'priority_id']), 'reminder', $reminder) );

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
