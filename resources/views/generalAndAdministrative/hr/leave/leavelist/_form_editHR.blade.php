<?php
use Carbon\Carbon;
?>
<div class="card">
	<div class="card-header">Edit Staff Leave {{ $staffLeaveHR->belongtostaff->name }}</div>
	<div class="card-body">

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
					<dd class="col-sm-9">{{ $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->annual_leave }} day/s</dd>
					<dt class="col-sm-3"><h5>Balance Initialize :</h5></dt>
					<dd class="col-sm-9" id="alb"><span id="albi">{{ $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->annual_leave_balance }}</span> day/s</dd>
					<dt class="col-sm-3"><h5>Balance Change :</h5></dt>
					<dd class="col-sm-9" id="alb"><span id="albc">{{ $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->annual_leave_balance }}</span> day/s</dd>
				</dl>
			</dd>
			{{ Form::hidden('balance', (is_null(@$value))?$staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->annual_leave_balance:@$value, ['id' => 'balance']) }}
@endif
@if( $staffLeaveHR->leave_id == 2 )
			<dt class="col-sm-3"><h5>Medical Leave :</h5></dt>
			<dd class="col-sm-9">
				<dl class="row">
					<dt class="col-sm-3"><h5>Initial :</h5></dt>
					<dd class="col-sm-9">{{ $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->medical_leave }} day/s</dd>
					<dt class="col-sm-3"><h5>Balance Initialize :</h5></dt>
					<dd class="col-sm-9" id="mlb"><span id="albi">{{ $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->medical_leave_balance }}</span> day/s</dd>
					<dt class="col-sm-3"><h5>Balance Change :</h5></dt>
					<dd class="col-sm-9" id="alb"><span id="albc">{{ $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->medical_leave_balance }}</span> day/s</dd>
				</dl>
			</dd>
			{{ Form::hidden('balance', (is_null(@$value))?$staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->medical_leave_balance:@$value, ['id' => 'balance']) }}
@endif
@if( $staffLeaveHR->leave_id == 3 || $staffLeaveHR->leave_id == 6 || $staffLeaveHR->leave_id == 11 )
			<dt class="col-sm-3"><h5>Unpaid Leave :</h5></dt>
			<dd class="col-sm-9">
				<dl class="row">
					<dt class="col-sm-3"><h5>Utilized All UPL :</h5></dt>
<?php
$upl = $staffLeaveHR->belongtostaff->hasmanystaffleave()->where('leave_id', 3)->get()->sum('period');
$elupl = $staffLeaveHR->belongtostaff->hasmanystaffleave()->where('leave_id', 6)->get()->sum('period');
$mcupl = $staffLeaveHR->belongtostaff->hasmanystaffleave()->where('leave_id', 11)->get()->sum('period');
?>
					<dd class="col-sm-9" id="ulb"><span id="albi">{{ $upl + $elupl + $mcupl }}</span> day/s</dd>



					<dt class="col-sm-3"><h5>New Utilized All UPL :</h5></dt>
					<dd class="col-sm-9" id="alb"><span id="albca">{{ $upl + $elupl + $mcupl }}</span> day/s</dd>

				</dl>
			</dd>
@endif
@if( $staffLeaveHR->leave_id == 7 )
			<dt class="col-sm-3"><h5>Maternity Leave :</h5></dt>
			<dd class="col-sm-9">
				<dl class="row">
					<dt class="col-sm-3"><h5>Initial :</h5></dt>
					<dd class="col-sm-9">{{ $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->maternity_leave }} day/s</dd>
					<dt class="col-sm-3"><h5>Balance Initialize :</h5></dt>
					<dd class="col-sm-9" id="matlb"><span id="albi">{{ $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->maternity_leave_balance }}</span> day/s</dd>
					<dt class="col-sm-3"><h5>Balance Change :</h5></dt>
					<dd class="col-sm-9" id="alb"><span id="albc">{{ $staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->maternity_leave_balance }}</span> day/s</dd>
				</dl>
			</dd>
			{{ Form::hidden('balance', (is_null(@$value))?$staffLeaveHR->belongtostaff->hasmanystaffannualmcleave()->where('year', Carbon::parse($staffLeaveHR->date_time_start)->format('Y') )->first()->maternity_leave_balance:@$value, ['id' => 'balance']) }}
@endif
@if( $staffLeaveHR->leave_id == 4 )
			<dt class="col-sm-3"><h5>Non Replacement Leave :</h5></dt>
			<dd class="col-sm-9">
				<dl class="row">
					<dt class="col-sm-3"><h5>Initialize :</h5></dt>
					<dd class="col-sm-9"><span id="">{{ $staffLeaveHR->hasmanystaffleavereplacement()->first()->leave_total }}</span> day/s</dd>
					<dt class="col-sm-3"><h5>Initial Utilized :</h5></dt>
					<dd class="col-sm-9" id="matlb"><span id="albi">{{ $staffLeaveHR->hasmanystaffleavereplacement()->first()->leave_balance }}</span> day/s</dd>
					<dt class="col-sm-3"><h5>Change Utilized :</h5></dt>
					<dd class="col-sm-9" id="matlb"><span id="albc">{{ $staffLeaveHR->hasmanystaffleavereplacement()->first()->leave_balance }}</span> day/s</dd>
				</dl>
			</dd>
			{{ Form::hidden('balance', (is_null(@$value))?$staffLeaveHR->hasmanystaffleavereplacement()->first()->leave_balance:@$value, ['id' => 'balance']) }}
@endif
		</dl>

<!-- --------------------------------------------------------------- form initialization -------------------------------------------------------------------------------- -->
<div class="container">
	<div class="row justify-content-center">
		<div class="col-sm-8" id="danger">

		</div>
	</div>
</div>


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
$s1 = \Carbon\Carbon::parse($dts);
$start = \Carbon\Carbon::create($s1->year, $s1->month ,$s1->day ,$s1->hour, $s1->minute, 0);
$pkl9 = \Carbon\Carbon::create($s1->year, $s1->month ,$s1->day ,9,0,0);
$pkl12 = \Carbon\Carbon::create($s1->year, $s1->month ,$s1->day ,12,0,0);
// echo $start;
?>
				<div class="pretty p-default p-curve form-check removetest">
					<input type="radio" name="leave_half" value="" id="am" {{ ( $start->lt($pkl9) )?'checked':'' }}>
					<div class="state p-primary">
						<label for="am" class="form-check-label am1"></label> 
					</div>
				</div>
				<div class="pretty p-default p-curve form-check removetest">
					<input type="radio" name="leave_half" value="" id="pm" {{ ( $start->gt($pkl9) )?'checked':'' }}>
					<div class="state p-primary">
						<label for="pm" class="form-check-label pm1"></label> 
					</div>
				</div>


@endif
			</div>
		</div>

		<div class="form-group row {{ $errors->has('period') ? 'has-error' : '' }}">
			{{ Form::label( 'per', 'Period : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('period', @$value, ['class' => 'form-control', 'id' => 'per', 'disabled']) }}
			</div>
		</div>
		{{ Form::hidden('period', @$value, ['id' => 'perday']) }}
@endif

@if( $staffLeaveHR->leave_id == 9 )

		<div class="form-group row {{ $errors->has('date_time_start') ? 'has-error' : '' }}">
			{{ Form::label( 'dtstf', 'Date : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('date_time_start', @$value, ['class' => 'form-control', 'id' => 'dtstf']) }}
			</div>
		</div>

<?php
$ts1 = $staffLeaveHR->date_time_start;
$te1 = $staffLeaveHR->date_time_end;
$ts2 = \Carbon\Carbon::parse($ts1);
$te2 = \Carbon\Carbon::parse($te1);

$ts3 = \Carbon\Carbon::create($ts2->year, $ts2->month, $ts2->day, $ts2->hour, $ts2->minute, 0)->format('H:i');
$te3 = \Carbon\Carbon::create($te2->year, $te2->month, $te2->day, $te2->hour, $te2->minute, 0)->format('H:i');

// echo $ts3;
?>
		<div class="form-group row {{ $errors->has('time_start') ? 'has-error' : '' }}">
			{{ Form::label( 'ts', 'Time From : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('time_start', (empty(@$value))?$ts3:@$value, ['class' => 'form-control', 'id' => 'ts']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('time_end') ? 'has-error' : '' }}">
			{{ Form::label( 'te', 'Time End : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('time_end', (empty(@$value))?$te3:@$value, ['class' => 'form-control', 'id' => 'te']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('period') ? 'has-error' : '' }}">
			{{ Form::label( 'per', 'Period : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('period', @$value, ['class' => 'form-control', 'id' => 'per', 'disabled']) }}
			</div>
		</div>
		{{ Form::hidden('period', @$value, ['id' => 'perday']) }}
@endif

		<div class="form-group row {{ $errors->has('remarks') ? 'has-error' : '' }}">
			{{ Form::label( 'per', 'Remarks : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::textarea('remarks', @$value, ['class' => 'form-control', 'id' => 'rem']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Update', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>
</div>