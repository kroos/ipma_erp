<?php
// load model
use \App\Model\ToDoList;
use \App\Model\ToDoStaff;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

$rt = ToDoList::all();
$st = ToDoStaff::where('staff_id', \Auth::user()->belongtostaff->id)->get();
// echo $st->count();

echo today()->format('Y-m-d').' today<br />';

// already in carbon format
$today = today()->format('Y-m-d');


foreach( $st as $key ) {
	// echo $key->id.' id user<br />';
	// echo $key->belongtoschedule.' schedule part<br />';
	foreach($key->belongtoschedule->hasmanytask()->get() as $ke) {
		// echo $ke.' user task list<br />';
	}
}
?>

@if($st->count() > 0)
<table class="table table-hover" id="todolist1" style="font-size:12px">
	<thead>
		<tr>
			<th>ID</th>
			<th>Task From</th>
			<th>Task</th>
			<th>Description</th>
			<th>Dateline</th>
			<th>Priority</th>
			<th>Accomplished</th>
		</tr>
	</thead>
	<tbody>
@foreach( $st as $key )
	@foreach( $key->belongtoschedule->hasmanytask()->get() as $ke )
	@if('et' == 'et')
		<tr>
			<td>{{ $ke->id }}</td>
			<td>{{ $key->belongtoschedule->belongtocreator->name }}</td>
			<td>{{ $key->belongtoschedule->task }}</td>
			<td>{{ $key->belongtoschedule->description }}</td>
			<td>{{ Carbon::parse($ke->dateline)->format('D, j F Y') }}</td>
			<td>{{ $key->belongtoschedule->belongtopriority->priority }}</td>
			<td>{{ $ke->completed }}</td>
		</tr>
		@endif
	@endforeach
@endforeach
	</tbody>
</table>
@endif