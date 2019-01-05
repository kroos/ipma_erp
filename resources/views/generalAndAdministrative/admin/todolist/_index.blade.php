<?php
use \App\Model\ToDoSchedule;
use Carbon\Carbon;
?>
<table class="table table-hover" id="schedule1" style="font-size:12px">
	<thead>
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
				<table class="table table-hover" id="schedule1" style="font-size:12px">
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