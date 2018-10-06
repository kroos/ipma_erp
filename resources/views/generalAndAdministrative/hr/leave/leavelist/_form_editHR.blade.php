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
@if( $staffLeaveHR->leave_id == 7 )
			<dt class="col-sm-3"><h5>Maternity Leave :</h5></dt>
			<dd class="col-sm-9">
				<dl class="row">
					<dt class="col-sm-3"><h5>Initial :</h5></dt>
					<dd class="col-sm-9">{{ $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->maternity_leave }}</dd>
					<dt class="col-sm-3"><h5>Balance :</h5></dt>
					<dd class="col-sm-9" id="matlb">{{ $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->maternity_leave_balance }}</dd>
				</dl>
			</dd>
@endif
@if( $staffLeaveHR->leave_id == 4 )
			<dt class="col-sm-3"><h5>Non Replacement Leave :</h5></dt>
			<dd class="col-sm-9">
				<dl class="row">
					<dt class="col-sm-3"><h5>Initialize :</h5></dt>
					<dd class="col-sm-9"></dd>
					<dt class="col-sm-3"><h5>Utilized :</h5></dt>
					<dd class="col-sm-9" id="matlb"></dd>
				</dl>
			</dd>
@endif
		</dl>


@if($staffLeaveHR->leave_id != 9)
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

		<div class="form-group row {{ $errors->has('leave_type') ? 'has-error' : '' }}" id="wrapperday">
			{{ Form::label('leave_type', 'Jenis Cuti : ', ['class' => 'col-sm-2 col-form-label removehalfleave']) }}
			<div class="col-sm-10 removehalfleave" id="halfleave">
				<div class="pretty p-default p-curve form-check removehalfleave" id="removeleavehalf">
					{{ Form::radio('leave_type', '1', ($staffLeaveHR->half_day != 2)?TRUE:NULL, ['id' => 'radio1', 'class' => ' removehalfleave']) }}
					<div class="state p-success removehalfleave">
						{{ Form::label('radio1', 'Cuti Penuh', ['class' => 'form-check-label removehalfleave']) }}
					</div>
				</div>
				<div class="pretty p-default p-curve form-check removehalfleave" id="appendleavehalf">
					{{ Form::radio('leave_type', '2', ($staffLeaveHR->half_day == 2)?TRUE:NULL, ['id' => 'radio2', 'class' => ' removehalfleave']) }}
					<div class="state p-success removehalfleave">
						{{ Form::label('radio2', 'Cuti Separuh', ['class' => 'form-check-label removehalfleave']) }}
					</div>
				</div>
			</div>

			<div class="form-group row col-sm-10 offset-sm-2 {{ $errors->has('leave_half') ? 'has-error' : '' }} removehalfleave"  id="wrappertest">
@if($staffLeaveHR->half_day == 2)
<?php
$dts = $staffLeaveHR->date_time_start;
$dte = $staffLeaveHR->date_time_end;

$exp1 = explode(' ', $dts);
$exp2 = explode(' ', $dte);
// echo $exp1[1].'<br />';
// echo $exp2[1].'<br />';
$s1 = \Carbon\Carbon::parse($exp1[1]);
$start = \Carbon\Carbon::create(2018,1,1,$s1->hour, $s1->minute, $s1->second);
$pkl9 = \Carbon\Carbon::create(2018,1,1,9,0,0);
$pkl12 = \Carbon\Carbon::create(2018,1,1,12,0,0);
$start = \Carbon\Carbon::create(2018,1,1,12,0,0);
// echo $start;
?>
				<div class="pretty p-default p-curve form-check removetest">
					<input type="radio" name="leave_half" value="" id="am" {{ ( $start->lt($pkl9) )?'checked':( $start->gte($pkl12) )?'checked':'' }}>
					<div class="state p-primary">
						<label for="am" class="form-check-label am1"></label> 
					</div>
				</div>
				<div class="pretty p-default p-curve form-check removetest">
					<input type="radio" name="leave_half" value="" id="pm" {{ ( $start->gt($pkl9) )?'checked':( $start->lte($pkl12) )?'checked':'' }}>
					<div class="state p-primary">
						<label for="pm" class="form-check-label pm1"></label> 
					</div>
				</div>
@endif
			</div>
		</div>
@endif






		{{ Form::hidden('periodday', @$value, ['id' => 'perday']) }}
		{{ Form::hidden('periodtime', @$value, ['id' => 'pertime']) }}



@if( $staffLeaveHR->leave_id == 9 )
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
@endif

		<div class="form-group row {{ $errors->has('time_start') ? 'has-error' : '' }}">
			{{ Form::label( 'per', 'Period : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('period', @$value, ['class' => 'form-control', 'id' => 'per', 'disabled']) }}
			</div>
		</div>

	</div>
</div>