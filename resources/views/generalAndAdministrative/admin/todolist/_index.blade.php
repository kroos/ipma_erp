<?php
use \App\Model\ToDoSchedule;
use \App\Model\ToDoList;
use Carbon\Carbon;
?>
<table class="table table-hover table-sm" id="schedule1" style="font-size:12px">
	<thead>
		<tr>
			<td colspan="11"><h3 class="text-center">Task Scheduler</h3></td>
		</tr>
		<tr>
			<th>ID</th>
			<th>Created By</th>
			<th>Category</th>
			<th>Task</th>
			<th>Description</th>
			<th>Period Reminder</th>
			<th>Dateline</th>
			<th>Priority</th>
			<th>Assignee</th>
			<th>Active</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
@foreach(ToDoSchedule::orderBy('category_id', 'ASC')->get() as $tds)
<?php
// Carbon::parse($tds->dateline)->format('jS F')
switch ($tds->category_id) {
	case 1:
	$dl = 'One Time On '.Carbon::parse($tds->dateline)->format('D, jS F Y');
		break;

	case 2:
	$dl = 'Every '.Carbon::parse($tds->dateline)->format('D');
		break;

	case 3:
	$dl = Carbon::parse($tds->dateline)->format('jS').' of every month';
		break;

	case 4:
	$dl = 'Every 3 months on '.Carbon::parse($tds->dateline)->format('jS');
		break;

	case 5:
	$dl = 'Every 6 months on '.Carbon::parse($tds->dateline)->format('jS');
		break;

	case 6:
	$dl = 'Yearly On '.Carbon::parse($tds->dateline)->format('jS F');
		break;
}
?>
		<tr class="{!! ($tds->priority_id == 1)?'table-danger':(($tds->priority_id == 2)?'table-warning':'table-info') !!}">
			<td>{!! $tds->id !!}</td>
			<td>{!! $tds->belongtocreator->name !!}</td>
			<td>{!! $tds->belongtocategory->category !!}</td>
			<td>{!! $tds->task !!}</td>
			<td>{!! $tds->description !!}</td>
			<td>{!! $tds->period_reminder !!} Days Before Dateline</td>
			<td>{!! $dl !!}</td>
			<td>{!! $tds->belongtopriority->priority !!}</td>
			<td>
				<table class="table table-hover table-sm" id="schedule1" style="font-size:12px">
					<tbody>
@foreach($tds->hasmanytasker()->get() as $t)
						<tr>
							<td>{!! $t->belongtostaff->name !!}</td>
						</tr>
@endforeach
					</tbody>
				</table>
			</td>
			<td>{!! ($tds->active == 1)?'Enable':'Disable' !!}</td>
			<td>
@if($tds->active == 1)
				<span id="toggle_{!! $tds->id !!}" class="text-success toggle" data-id="{!! $tds->id !!}" data-value="0"><i class="fa fa-toggle-on"></i></span>
@else
				<span id="toggle_{!! $tds->id !!}" class="text-danger toggle" data-id="{!! $tds->id !!}" data-value="1"><i class="fa fa-toggle-off"></i></span>
@endif
			</td>
		</tr>
@endforeach
	</tbody>
</table>

<p>&nbsp</p>

<table class="table table-hover table-sm" id="schedule2" style="font-size:12px">
	<thead>
		<tr>
			<th colspan="11">
				<h3 class="text-center">Incomplete Task With Reply From Tasker</h3>
			</th>
		</tr>
		<tr>
			<th>ID Schedule</th>
			<th>Category</th>
			<th>Task</th>
			<th>Description</th>
			<th>Reminder On</th>
			<th>Dateline On</th>
			<th>Priority</th>
			<th>Accomplished</th>
			<th>Remarks</th>
			<th>From</th>
			<th>Updated At</th>
		</tr>
	</thead>
	<tbody>
@foreach( ToDoList::whereNotNull('remarks')->whereNull('completed')->get() as $y )
		<tr class="{!! ($y->belongtoschedule->priority_id == 1)?'table-danger':(($y->belongtoschedule->priority_id == 2)?'table-warning':'table-info') !!}">
			<td>{!! $y->belongtoschedule->id !!}</td>
			<td>{!! $y->belongtoschedule->belongtocategory->category !!}</td>
			<td>{!! $y->belongtoschedule->task !!}</td>
			<td>{!! $y->belongtoschedule->description !!}</td>
			<td>{!! Carbon::parse($y->reminder)->format('D, j F Y') !!}</td>
			<td>{!! Carbon::parse($y->reminder)->format('D, j F Y') !!}</td>
			<td>{!! $y->belongtoschedule->belongtopriority->priority !!}</td>
			<td>{!! (!is_null($y->completed))?'Accomplished':'Incomplete' !!}</td>
			<td>{!! $y->remarks !!}</td>
			<td>{{ $y->belongtodoers->name }}</td>
			<td>{!! Carbon::parse($y->updated_at)->format('D, j M Y') !!}</td>
		</tr>
@endforeach
	</tbody>
</table>
<p>&nbsp;</p>

<table class="table table-hover table-sm" id="schedule3" style="font-size:12px">
	<thead>
		<tr>
			<th colspan="11">
				<h3 class="text-center">Complete Task</h3>
			</th>
		</tr>
		<tr>
			<th>ID Schedule</th>
			<th>Category</th>
			<th>Task</th>
			<th>Description</th>
			<th>Reminder On</th>
			<th>Dateline On</th>
			<th>Priority</th>
			<th>Accomplished</th>
			<th>Remarks</th>
			<th>From</th>
			<th>Updated At</th>
		</tr>
	</thead>
	<tbody>
@foreach( ToDoList::whereNotNull('completed')->get() as $y )
		<tr class="{!! ($y->belongtoschedule->priority_id == 1)?'table-danger':(($y->belongtoschedule->priority_id == 2)?'table-warning':'table-info') !!}">
			<td>{!! $y->belongtoschedule->id !!}</td>
			<td>{!! $y->belongtoschedule->belongtocategory->category !!}</td>
			<td>{!! $y->belongtoschedule->task !!}</td>
			<td>{!! $y->belongtoschedule->description !!}</td>
			<td>{!! Carbon::parse($y->reminder)->format('D, j F Y') !!}</td>
			<td>{!! Carbon::parse($y->reminder)->format('D, j F Y') !!}</td>
			<td>{!! $y->belongtoschedule->belongtopriority->priority !!}</td>
			<td>{!! (!is_null($y->completed))?'Accomplished':'Incomplete' !!}</td>
			<td>{!! $y->remarks !!}</td>
			<td>{{ $y->belongtodoers->name }}</td>
			<td>{!! Carbon::parse($y->updated_at)->format('D, j M Y') !!}</td>
		</tr>
@endforeach
	</tbody>
</table>