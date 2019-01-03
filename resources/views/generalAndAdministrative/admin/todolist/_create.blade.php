<?php
use \App\Model\ToDoCategory;
use \App\Model\ToDoPriority;
use \App\Model\Staff;
$cat = ToDoCategory::whereNotIn('id', [2, 4, 5])->pluck('category', 'id')->toArray();
$pri = ToDoPriority::pluck('priority', 'id')->toArray();
$sta = Staff::where('active', 1)->get();
?>

<div class="form-group row {{ $errors->has('category_id') ? ' has-error' : '' }}">
	{!! Form::label('cat', 'Category :', ['class' => 'col-sm-2 col-form-label']) !!}
	<div class="col-sm-10">
		{!! Form::select('category_id', $cat, @$value, ['placeholder' => 'Please choose', 'id' => 'cat', 'class' => 'form-control']) !!}
	</div>
</div>

<div class="form-group row {{ $errors->has('category_id') ? ' has-error' : '' }}">
	{!! Form::label('assig', 'Assignee :', ['class' => 'col-sm-2 col-form-label']) !!}
	<div class="col-sm-10">

		<div class="container-fluid position_wrap">
			<div class="rowposition">
				<div class="form-row col-sm-12">
					<div class="col-sm-1 text-danger">
							<i class="fas fa-trash remove_position1" aria-hidden="true" id="button_delete_1" data-id="1"></i>
					</div>
					<div class="col">
						<div class="form-group {{ $errors->has('td.*.staff_id') ? 'has-error' : '' }}">
							<select name="td[1][staff_id]" id="staff_id_1" class="form-control">
								<option value="">Please choose</option>
@foreach($sta as $st)
								<option value="{!! $st->id !!}">{!! $st->hasmanylogin()->where('active', 1)->first()->username !!} {!! $st->name !!}</option>
@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="row col-lg-12 add_position">
			<p class="text-primary"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Assignee</p>
		</div>

	</div>
</div>

<div class="form-group row {{ $errors->has('task') ? ' has-error' : '' }}">
	{!! Form::label('task', 'Task :', ['class' => 'col-sm-2 col-form-label']) !!}
	<div class="col-sm-10">
		{!! Form::text('task', @$value, ['placeholder' => 'Task', 'id' => 'task', 'class' => 'form-control']) !!}
	</div>
</div>

<div class="form-group row {{ $errors->has('description') ? ' has-error' : '' }}">
	{!! Form::label('desc', 'Description :', ['class' => 'col-sm-2 col-form-label']) !!}
	<div class="col-sm-10">
		{!! Form::textarea('description', @$value, ['placeholder' => 'Description', 'id' => 'desc', 'class' => 'form-control']) !!}
	</div>
</div>

<div class="form-group row {{ $errors->has('dateline') ? ' has-error' : '' }}">
	{!! Form::label('line', 'Dateline :', ['class' => 'col-sm-2 col-form-label']) !!}
	<div class="col-sm-10">
			{!! Form::text('dateline', @$value, ['placeholder' => 'Dateline', 'id' => 'line', 'class' => 'form-control']) !!}
	</div>
</div>

<div class="form-group row {{ $errors->has('period_reminder') ? ' has-error' : '' }}">
	{!! Form::label('per', 'Reminder :', ['class' => 'col-sm-2 col-form-label']) !!}
	<div class="col-sm-10">
		{!! Form::text('period_reminder', @$value, ['placeholder' => 'Reminder', 'id' => 'per', 'class' => 'form-control', 'aria-describedby' => 'reminderHelp']) !!}
		<small id="reminderHelp" class="form-text text-muted">How many days from dateline before the reminder kick in.</small>
	</div>
</div>

<div class="form-group row {{ $errors->has('priority_id') ? ' has-error' : '' }}">
	{!! Form::label('prio', 'Priority :', ['class' => 'col-sm-2 col-form-label']) !!}
	<div class="col-sm-10">
		{!! Form::select('priority_id', $pri, @$value, ['placeholder' => 'Please choose', 'id' => 'prio', 'class' => 'form-control']) !!}
	</div>
</div>

<div class="form-group row">
	<div class="col-sm-10 offset-sm-2">
		{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
	</div>
</div>

