<?php
use \App\Model\StaffTCMS;
use \App\Model\Staff;
use \App\Model\WorkingHour;

use \Carbon\Carbon;

$tcms = StaffTCMS::orderBy('date', 'desc')->paginate(200);

$i = 0;
?>
<ul class="nav nav-pills">
	<li class="nav-item">
		<a class="nav-link" href="">Settings</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('staffTCMS.index') }}">Attendance</a>
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
	<div class="card-header">Attendance</div>
	<div class="card-body">

		{!! Form::open(['route' => ['staffTCMS.store'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true, 'autocomplete' => 'off']) !!}
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Date Attendance : </span>
			</div>
			<!-- <input type="text" aria-label="First name" class="form-control"> -->
			{{ Form::text('date', @$value, ['class' => 'form-control', 'aria-label' => 'Date Start', 'id' => 'dte']) }}
			<div class="input-group-append">
				<button class="btn btn-outline-primary" type="submit" id="search">Search</button>
			</div>
		</div>
		{!! Form::close() !!}

		<p>&nbsp;</p>


<table class="table table-hover table-sm" id="leaves" style="font-size:12px">
	<thead>
		<tr>
			<th>#</th>
			<th>Date</th>
			<th>Location</th>
			<th>Name</th>
			<th>Day Type</th>
			<th>In</th>
			<th>Break</th>
			<th>Resume</th>
			<th>Out</th>
			<th>Work</th>
			<th>Short Hour</th>
			<th>Overtime</th>
			<th>Leave Taken</th>
			<th>Remarks</th>
			<th>HR Ref Form</th>
			<th>Exception</th>
		</tr>
	</thead>
	<tbody>
@foreach( $tcms as $tc )
@if( $tc->belongtostaff->active == 1 && Carbon::parse($tc->date)->dayOfWeek != 0 )

<?php
	// time constant
	$userposition = $tc->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
	$dt = Carbon::parse($tc->date);

	// echo $userposition->id; // 60
	// echo $dt->year; // 2019
	// echo $dt->dayOfWeek; // dayOfWeek returns a number between 0 (sunday) and 6 (saturday) // 5

	if( $userposition->id == 72 && $dt->dayOfWeek != 5 ) {	// checking for friday
		$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 8);
	} else {
		if ( $userposition->id == 72 && $dt->dayOfWeek == 5 ) {	// checking for friday
			$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 8);
		} else {
			if( $userposition->id != 72 && $dt->dayOfWeek != 5 ) {	// checking for friday
				// normal
				$time = \App\Model\WorkingHour::where('year', $dt->year)->whereRaw('"'.$dt.'" BETWEEN working_hours.effective_date_start AND working_hours.effective_date_end' )->limit(1);
			} else {
				if( $userposition->id != 72 && $dt->dayOfWeek == 5 ) {	// checking for friday
					$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 3)->whereRaw('"'.$dt.'" BETWEEN working_hours.effective_date_start AND working_hours.effective_date_end' )->limit(1);
				}
			}
		}
	}
//	echo 'start_am => '.$time->first()->time_start_am;
//	echo ' end_am => '.$time->first()->time_end_am;
//	echo ' start_pm => '.$time->first()->time_start_pm;
//	echo ' end_pm => '.$time->first()->time_end_pm.'<br />';

$in = Carbon::createFromTimeString($tc->in);
$break = Carbon::createFromTimeString($tc->break);
$resume = Carbon::createFromTimeString($tc->resume);
$out = Carbon::createFromTimeString($tc->out);

if( $tc->in != '00:00:00' ) {
	if( $in->lte( Carbon::createFromTimeString($time->first()->time_start_am) ) ) {
		$in1 = '<span class="text-success">'.$in->format('h:i a').'</span>';
	} else {
		$in1 = '<span class="text-danger">'.$in->format('h:i a').'</span>';
	}
} else {
	$in1 = NULL;
}
$i++;
?>

		<tr>
			<td>{!! $i !!}</td>
			<td>{!! Carbon::parse($tc->date)->format('D, j M Y') !!}</td>
			<td>{!! $tc->belongtostaff->belongtolocation->location !!}</td>
			<td>{!! $tc->belongtostaff->name !!}</td>
			<td>{{ $tc->daytype }}</td>
			<td>{!! $in1 !!}</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
@endif
@endforeach
	</tbody>
</table>








{!! $tcms->links() !!}
	</div>
</div>