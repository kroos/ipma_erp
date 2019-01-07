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
			<td><span class="text-primary update" title="Update" data-id="{!! $ke->id !!}" data-toggle="modal" data-target="#form-{!! $ke->id !!}"><i class="fas fa-pen-alt"></i></span></td>
		</tr>
		<!-- Modal -->
		<div class="modal fade" id="form-{!! $ke->id !!}" tabindex="-1" role="dialog" aria-labelledby="Form-{!! $ke->id !!}" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="Form-{!! $ke->id !!}">Update Task List</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						{!! Form::open(['route' => ['todoList.updatetask', $ke->id], 'method' => 'PATCH', 'class' => 'form', 'autocomplete' => 'off', 'files' => true]) !!}
							<div class="form-group row">
								{!! Form::label('rem', 'Remarks :', ['class' => 'col-sm-4 col-form-label']) !!}
								<div class="col-sm-8">
									{!! Form::textarea('description', @$value, ['class' => 'form-control form-control-sm', 'id' => 'rem', 'placeholder' => 'Remarks', 'required' => 'required']) !!}
								</div>
							</div>
							<div class="form-group row">
								{!! Form::label('rem', 'Accomplished :', ['class' => 'col-sm-4 col-form-label']) !!}
								<div class="col-sm-8">
									<div class="pretty p-switch p-fill form-check">
										{!! Form::checkbox('completed', 1, false, ['class' => 'form-check-input', 'id' => 'yes']) !!}
										<div class="state p-success">
											{!! Form::label('yes', 'Yes', ['class' => 'form-check-label']) !!}
										</div>
									</div>
								</div>
							</div>
					</div>
					<div class="modal-footer">
						{!! Form::button('Close', ['type' => 'button', 'class' => 'btn btn-primary', 'data-dismiss' => 'modal']) !!}
						{!! Form::button('Update', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
					</div>
						{!! Form::close() !!}
				</div>
			</div>
		</div>
<!-- modal end -->
	@endforeach
@endforeach
	</tbody>
</table>
@endif