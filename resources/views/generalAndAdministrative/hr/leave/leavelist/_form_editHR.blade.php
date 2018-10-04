<?php
use Carbon\Carbon;
?>
<div class="card">
	<div class="card-header">Edit Staff Leave {{ $staffLeaveHR->belongtostaff->name }}</div>
	<div class="card-body">

		<dl class="row">
			<dt class="col-sm-3"><h5 class="text-danger">SYSTEM REMINDER :</h5></dt>
			<dd class="col-sm-9">
				<p>AMEND function will ignore all the <strong>Restriction</strong> (Date/Balance/Type Checking) and if there is any changes (total days) that affected the current balance (AL,EL-AL/MC, UPL), it should be change manually with the help of IT staff.</p>
			</dd>
		</dl>

		<dl class="row">
			<dt class="col-sm-3"><h6>No. Staff :</h5></dt>
			<dd class="col-sm-9">{{ $staffLeaveHR->belongtostaff->hasmanylogin()->where('active', 1)->first()->username }}</dd>
			<dt class="col-sm-3"><h6>Apply Date :</h5></dt>
			<dd class="col-sm-9">{{ Carbon::parse($staffLeaveHR->created_at)->format('D, j M Y') }}</dd>
			<dt class="col-sm-3"><h6>Reason :</h5></dt>
			<dd class="col-sm-9">{{ ucwords(strtolower($staffLeaveHR->reason)) }}</dd>
			<dt class="col-sm-3"><h6>Leave Type :</h5></dt>
			<dd class="col-sm-9">{{ $staffLeaveHR->belongtoleave->leave }}</dd>
		</dl>

		<div class="form-group row {{ $errors->has('date_time_start') ? 'has-error' : '' }}">
			{{ Form::label( 'dts', 'From : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('date_time_start', @$value, ['class' => 'form-control', 'id' => 'dts']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('date_time_end') ? 'has-error' : '' }}">
			{{ Form::label( 'dte', 'To : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('date_time_end', @$value, ['class' => 'form-control', 'id' => 'dte']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('time_start') ? 'has-error' : '' }}">
			{{ Form::label( 'ts', 'Time From : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('time_start', @$value, ['class' => 'form-control', 'id' => 'ts']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('time_start') ? 'has-error' : '' }}">
			{{ Form::label( 'te', 'Time End : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('time_end', @$value, ['class' => 'form-control', 'id' => 'te']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('time_start') ? 'has-error' : '' }}">
			{{ Form::label( 'per', 'Period : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('period', @$value, ['class' => 'form-control', 'id' => 'per', 'disabled']) }}
			</div>
		</div>

	</div>
</div>