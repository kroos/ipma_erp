<?php
use \Carbon\Carbon;
use \App\Model\StaffLeaveReplacement;
use \App\Model\Staff;
use \App\Model\StaffLeave;

$now = Carbon::now();
?>
<ul class="nav nav-pills">
	<li class="nav-item">
		<a class="nav-link " href="{{ route('leaveSetting.index') }}">Settings</a>
	</li>
	<li class="nav-item">
		<a class="nav-link active" href="{{ route('leaveNRL.index') }}">Non Record Leave</a>
	</li>
<!-- 	<li class="nav-item">
		<a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="{{ route('leaveList.index') }}">Leave List</a>
		<div class="dropdown-menu">
			<a class="dropdown-item" href="#">Action</a>
			<a class="dropdown-item" href="#">Another action</a>
			<a class="dropdown-item" href="#">Something else here</a>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="#">Separated link</a>
		</div>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="#">check lain function yang ada</a>
	</li> -->
</ul>

<div class="card">
	<div class="card-header">Update Replacement Leave for {!! $staffLeaveReplacement->belongtostaff->name !!}</div>
	<div class="card-body table-responsive">
		@include('layouts.info')
		@include('layouts.errorform')

		<div class="form-group row {{ $errors->has('working_date') ? ' has-error' : '' }}">
			{{ Form::label('wd', 'Working Date : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('working_date', @$value, ['class' => 'form-control', 'id' => 'wd', 'placeholder' => 'Working Date', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('working_location') ? ' has-error' : '' }}">
			{{ Form::label('wl', 'Working Location : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('working_location', @$value, ['class' => 'form-control', 'id' => 'wl', 'placeholder' => 'Working Date', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('working_reason') ? ' has-error' : '' }}">
			{{ Form::label('wr', 'Working Reason : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('working_reason', @$value, ['class' => 'form-control', 'id' => 'wr', 'placeholder' => 'Working Reason', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('leave_total') ? ' has-error' : '' }}">
			{{ Form::label('lt', 'Leave Total : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('leave_total', @$value, ['class' => 'form-control', 'id' => 'lt', 'placeholder' => 'Leave Total', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('leave_utilize') ? ' has-error' : '' }}">
			{{ Form::label('lu', 'Leave Utilize : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('leave_utilize', @$value, ['class' => 'form-control', 'id' => 'lu', 'placeholder' => 'Leave Utilize', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('leave_balance') ? ' has-error' : '' }}">
			{{ Form::label('lb', 'Leave Balance : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('leave_balance', @$value, ['class' => 'form-control', 'id' => 'lb', 'placeholder' => 'Leave Balance', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('remarks') ? ' has-error' : '' }}">
			{{ Form::label('remarks', 'Remarks : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::textarea('remarks', @$value, ['class' => 'form-control', 'id' => 'remarks', 'placeholder' => 'Remarks', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Update', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>
</div>