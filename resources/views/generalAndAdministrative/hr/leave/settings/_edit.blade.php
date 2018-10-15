<?php
use \App\Model\Staff;
use \App\Model\StaffAnnualMCLeave;

use \Carbon\Carbon;

$n = Carbon::now();

$s = Staff::where('active', 1)->orderBy('name', 'asc')->get();
?>
<ul class="nav nav-pills">
	<li class="nav-item">
		<a class="nav-link active" href="{{ route('leaveSetting.index') }}">Settings</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('leaveNRL.index') }}">Non Replacement Leave</a>
	</li>
	<li class="nav-item">
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
	</li>
</ul>

<div class="card">
	<div class="card-header">Edit Staff Annual Leave, Medical Certificate Leave And Maternity Leave for {{ $staffAnnualMCLeave->belomgtostaff->name }} on {{ $staffAnnualMCLeave->year }}.</div>
	<div class="card-body">

		<div class="form-group row {{ $errors->has('year') ? ' has-error' : '' }}">
			{{ Form::label('year', 'Year : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('year', @$value, ['class' => 'form-control', 'id' => 'year', 'placeholder' => 'Year', 'autocomplete' => 'off', 'disabled']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('annual_leave') ? ' has-error' : '' }}">
			{{ Form::label('al', 'Annual Leave Initialize : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('annual_leave', @$value, ['class' => 'form-control', 'id' => 'al', 'placeholder' => 'Annual Leave Initialize', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('annual_leave_adjustment') ? ' has-error' : '' }}">
			{{ Form::label('ala', 'Annual Leave Adjustment : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('annual_leave_adjustment', @$value, ['class' => 'form-control', 'id' => 'ala', 'placeholder' => 'Annual Leave Adjustment', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('annual_leave_balance') ? ' has-error' : '' }}">
			{{ Form::label('alb', 'Annual Leave Balance : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('annual_leave_balance', @$value, ['class' => 'form-control', 'id' => 'alb', 'placeholder' => 'Annual Leave Balance', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('medical_leave') ? ' has-error' : '' }}">
			{{ Form::label('mc', 'Medical Certificate Leave Initialize : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('medical_leave', @$value, ['class' => 'form-control', 'id' => 'mc', 'placeholder' => 'Medical Certificate Leave Initialize', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('medical_leave_adjustment') ? ' has-error' : '' }}">
			{{ Form::label('mca', 'Medical Certificate Leave Adjustment : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('medical_leave_adjustment', @$value, ['class' => 'form-control', 'id' => 'mca', 'placeholder' => 'Medical Certificate Leave Adjustment', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('medical_leave_balance') ? ' has-error' : '' }}">
			{{ Form::label('mcb', 'Medical Certificate Leave Balance : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('medical_leave_balance', @$value, ['class' => 'form-control', 'id' => 'mcb', 'placeholder' => 'Medical Certificate Leave Balance', 'autocomplete' => 'off']) }}
			</div>
		</div>
@if( $staffAnnualMCLeave->belomgtostaff->gender_id == 2 )
		<div class="form-group row {{ $errors->has('maternity_leave') ? ' has-error' : '' }}">
			{{ Form::label('ml', 'Maternity Leave Initialize : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('maternity_leave', @$value, ['class' => 'form-control', 'id' => 'ml', 'placeholder' => 'Maternity Leave Initialize', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('maternity_leave_balance') ? ' has-error' : '' }}">
			{{ Form::label('mlb', 'Maternity Leave Balance : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('maternity_leave_balance', @$value, ['class' => 'form-control', 'id' => 'mlb', 'placeholder' => 'Maternity Leave Balance', 'autocomplete' => 'off']) }}
			</div>
		</div>
@endif
		<div class="form-group row {{ $errors->has('remarks') ? ' has-error' : '' }}">
			{{ Form::label('rem', 'Remarks : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::textarea('remarks', @$value, ['class' => 'form-control', 'id' => 'rem', 'placeholder' => 'Remarks', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Update', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>
</div>