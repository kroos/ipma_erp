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
			<dt class="col-sm-3"><h5>No. Staff :</h5></dt>
			<dd class="col-sm-9">{{ $staffLeaveHR->belongtostaff->hasmanylogin()->where('active', 1)->first()->username }}</dd>
			<dt class="col-sm-3"><h5>Apply Date :</h5></dt>
			<dd class="col-sm-9">{{ Carbon::parse($staffLeaveHR->created_at)->format('D, j M Y') }}</dd>
			<dt class="col-sm-3"><h5>Reason :</h5></dt>
			<dd class="col-sm-9">{{ ucwords(strtolower($staffLeaveHR->reason)) }}</dd>
			<dt class="col-sm-3"><h5>Leave Type :</h5></dt>
			<dd class="col-sm-9">{{ $staffLeaveHR->belongtoleave->leave }}</dd>

@if( $staffLeaveHR->leave_id == 1 || $staffLeaveHR->leave_id == 5 )
			<dt class="col-sm-3"><h5>Annual Leave :</h5></dt>
			<dd class="col-sm-9">
				<dl class="row">
					<dt class="col-sm-3"><h5>Initial :</h5></dt>
					<dd class="col-sm-9">{{ $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->annual_leave }}</dd>
					<dt class="col-sm-3"><h5>Balance :</h5></dt>
					<dd class="col-sm-9" id="alb">{{ $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->annual_leave_balance }}</dd>
				</dl>
			</dd>
@endif
@if( $staffLeaveHR->leave_id == 2 )
			<dt class="col-sm-3"><h5>Medical Leave :</h5></dt>
			<dd class="col-sm-9">
				<dl class="row">
					<dt class="col-sm-3"><h5>Initial :</h5></dt>
					<dd class="col-sm-9">{{ $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->medical_leave }}</dd>
					<dt class="col-sm-3"><h5>Balance :</h5></dt>
					<dd class="col-sm-9" id="mlb">{{ $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->medical_leave_balance }}</dd>
				</dl>
			</dd>
@endif
@if( $staffLeaveHR->leave_id == 3 || $staffLeaveHR->leave_id == 6 || $staffLeaveHR->leave_id == 11 )
			<dt class="col-sm-3"><h5>Unpaid Leave :</h5></dt>
			<dd class="col-sm-9">
				<dl class="row">
					<dt class="col-sm-3"><h5>Utilized :</h5></dt>
<?php
$upl = $staffLeaveHR->belongtostaff->hasmanystaffleave()->where('leave_id', 3)->get()->sum('period');
$elupl = $staffLeaveHR->belongtostaff->hasmanystaffleave()->where('leave_id', 6)->get()->sum('period');
$mcupl = $staffLeaveHR->belongtostaff->hasmanystaffleave()->where('leave_id', 11)->get()->sum('period');
?>
					<dd class="col-sm-9" id="ulb">{{ $upl + $elupl + $mcupl }}</dd>
				</dl>
			</dd>
@endif
			<dt class="col-sm-3"><h5>Maternity Leave :</h5></dt>
			<dd class="col-sm-9">
				<dl class="row">
					<dt class="col-sm-3"><h5>Initial :</h5></dt>
					<dd class="col-sm-9">{{ $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->maternity_leave }}</dd>
					<dt class="col-sm-3"><h5>Balance :</h5></dt>
					<dd class="col-sm-9" id="matlb">{{ $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->maternity_leave_balance }}</dd>
				</dl>
			</dd>

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
@if( $staffLeaveHR->leave_id != 9 || ($staffLeaveHR->half_day == 1) )
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
@endif

	</div>
</div>