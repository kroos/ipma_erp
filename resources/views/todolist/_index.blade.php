<?php
// load model
use \App\Model\ToDoList;
use \App\Model\ToDoStaff;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

$st = ToDoStaff::where('staff_id', \Auth::user()->belongtostaff->id)->get();

$cnt = 0;
foreach( $st as $key ) {
	// echo $key->id.' id user<br />';
	// echo $key->belongtoschedule.' schedule part<br />';
	$cnt += $key->belongtoschedule->hasmanytask()->whereDate('reminder', '<=', today())->whereNull('completed')->get()->count();
}
?>

@if($st->count() > 0)
<table class="table table-hover table-sm" id="todolist1" style="font-size:12px">
	<thead>
		<tr>
			<th>ID</th>
			<th>Category</th>
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
	@foreach( $key->belongtoschedule->hasmanytask()->whereDate('reminder', '<=', today())->whereNull('completed')->get() as $ke )
		<tr class="{!! ($key->belongtoschedule->priority_id == 1)?'table-danger':(($key->belongtoschedule->priority_id == 2)?'table-warning':'table-info') !!}">
			<td>{{ $ke->id }}</td>
			<td>{{ $key->belongtoschedule->belongtocategory->category }}</td>
			<td>{{ $key->belongtoschedule->belongtocreator->name }}</td>
			<td>{{ $key->belongtoschedule->task }}</td>
			<td>{{ $key->belongtoschedule->description }}</td>
			<td>{{ Carbon::parse($ke->dateline)->format('D, j F Y') }}</td>
			<td>{{ $key->belongtoschedule->belongtopriority->priority }}</td>
			<td><span class="text-primary update" title="Update" data-id="{!! $ke->id !!}"><i class="fas fa-pen-alt"></i></span></td>
		</tr>
	@endforeach
@endforeach
	</tbody>
</table>
@endif