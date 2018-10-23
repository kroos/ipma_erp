<?php
use \App\Model\StaffTCMS;
use \App\Model\Staff;
use \App\Model\StaffLeave;
use \App\Model\WorkingHour;

use \Carbon\Carbon;

$n = Carbon::now();
// $n1 = $n->copy()->startOfMonth();
$n1 = $n->copy()->startOfWeek();
// echo $n1.' start of month<br />';
$tcms = StaffTCMS::where('date', '>=', $n1)->orderBy('date', 'desc')->get();
?>
<ul class="nav nav-pills">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('staffTCMS.create') }}">ODBC / CSV Uploader</a>
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
	<div class="card-body table-responsive">

		{!! Form::open(['route' => ['printpdftcms.store'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true, 'autocomplete' => 'off']) !!}
		<h4>Generate Report</h4>
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">Date Attendance : </span>
			</div>
			<!-- <input type="text" aria-label="First name" class="form-control"> -->
			{{ Form::text('date_start', @$value, ['class' => 'form-control', 'aria-label' => 'Date Start', 'placeholder' => 'Date Start', 'id' => 'dts']) }}
			{{ Form::text('date_end', @$value, ['class' => 'form-control', 'aria-label' => 'Date End', 'placeholder' => 'Date End', 'id' => 'dte']) }}
			<div class="input-group-append">
				<button class="btn btn-outline-primary" type="submit" target="_blank" id="search">Report</button>
			</div>
		</div>
		{!! Form::close() !!}

		<p>&nbsp;</p>


<table class="table table-hover table-sm" id="attendance" style="font-size:12px">
	<thead>
		<tr>
			<th>Date</th>
			<th>Location</th>
			<th>Staff ID</th>
			<th>Name</th>
			<th>Day Type</th>
			<th>In</th>
			<th>Break</th>
			<th>Resume</th>
			<th>Out</th>
			<th>Work Hour</th>
			<th>Short Hour</th>
			<th>Overtime</th>
			<th>Leave Taken</th>
			<th>Remarks</th>
			<th>HR Ref Form</th>
			<th>Exception</th>
			<th>&nbsp;</th>
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

if( $userposition->category_id == 2 OR $userposition->group_id == 4 ) {	// check for OT and ramadhan month
	if ( $out->eq( Carbon::createFromTimeString('00:00:00') ) ) {
		$ot = NULL;
	} else {
		// if endPM for category_id = 2 or group_id = 4 => 5:45pm, means normal day
		// if endPM for category_id = 2 or group_id = 4 => 5:00pm, means ramadhan month
		if( Carbon::createFromTimeString($time->first()->time_end_pm)->eq( Carbon::createFromTimeString('17:45:00') ) ) {
			// $ot = 'normal months.<br />';
			if ( $out->lt( Carbon::createFromTimeString('18:50:00') ) ) {
				$ot = NULL;
			} else {
				if( $out->gte( Carbon::createFromTimeString('18:50:00') ) && $out->lt( Carbon::createFromTimeString('19:20:00') ) ) {
					$ot = '<span class="text-primary">1 hour</span>';
				} else {
					if ( $out->gte( Carbon::createFromTimeString('19:20:00') ) && $out->lt( Carbon::createFromTimeString('19:50:00') ) ) {
						$ot = '<span class="text-primary">1.5 hours</span>';
					} else {
						if ( $out->gte( Carbon::createFromTimeString('19:50:00') ) && $out->lt( Carbon::createFromTimeString('20:20:00') ) ) {
							$ot = '<span class="text-primary">2 hours</span>';
						} else {
							if ( $out->gte( Carbon::createFromTimeString('20:20:00') ) && $out->lt( Carbon::createFromTimeString('20:50:00') ) ) {
								$ot = '<span class="text-primary">2.5 hours</span>';
							} else {
								if ( $out->gte( Carbon::createFromTimeString('20:50:00') ) && $out->lt( Carbon::createFromTimeString('21:20:00') ) ) {
									$ot = '<span class="text-primary">3 hours</span>';
								} else {
									if ( $out->gte( Carbon::createFromTimeString('21:20:00') ) && $out->lt( Carbon::createFromTimeString('21:50:00') ) ) {
										$ot = '<span class="text-primary">3.5 hours</span>';
									} else {
										if ( $out->gte( Carbon::createFromTimeString('21:50:00') ) && $out->lt( Carbon::createFromTimeString('22:20:00') ) ) {
											$ot = '<span class="text-primary">4 hours</span>';
										}
									}
								}
							}
						}
					}
				}
			}
		} else {
			if( Carbon::createFromTimeString($time->first()->time_end_pm)->eq( Carbon::createFromTimeString('17:00:00') ) ) {
				// $ot = 'ramadhan months.<br />';
				if($out->lt(Carbon::createFromTimeString('17:50:00'))) {
					$ot = NULL;
				} else {
					if( $out->gte( Carbon::createFromTimeString('17:50:00') ) && $out->lt( Carbon::createFromTimeString('18:20:00') ) ) {
						$ot = '<span class="text-primary">1 hour</span>';
					} else {
						if ( $out->gte( Carbon::createFromTimeString('18:20:00') ) && $out->lt( Carbon::createFromTimeString('18:50:00') ) ) {
							$ot = '<span class="text-primary">1.5 hours</span>';
						} else {
							if ( $out->gte( Carbon::createFromTimeString('18:50:00') ) && $out->lt( Carbon::createFromTimeString('19:20:00') ) ) {	// ramadhan month only at 7pm for OT
								$ot = '<span class="text-primary">2 hours</span>';
							}
						}
					}
				}
			}
		}
	}
} else {
	$ot = NULL;
}

if( $tc->in != '00:00:00' ) {
	if( $in->lte( Carbon::createFromTimeString($time->first()->time_start_am) ) ) {
		$in1 = '<span class="text-success">'.$in->format('h:i a').'</span>';
	} else {
		$in1 = '<span class="text-danger">'.$in->format('h:i a').'</span>';
	}
} else {
	$in1 = NULL;
}

if( $tc->out != '00:00:00' ) {
	if( $out->gte( Carbon::createFromTimeString($time->first()->time_end_pm) ) ) {
		$out1 = '<span class="text-success">'.$out->format('h:i a').'</span>';
	} else {
		$out1 = '<span class="text-danger">'.$out->format('h:i a').'</span>';
	}
} else {
	$out1 = NULL;
}

// looking for appropriate leaves for user.
$lea = StaffLeave::where('staff_id', $tc->staff_id)->whereRaw('"'.$tc->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->first();
if ( !empty( $lea ) ) {
	$dts = Carbon::parse($lea->created_at)->format('Y');
	$arr = str_split( $dts, 2 );
	$leaid = 'HR9-'.str_pad( $lea->leave_no, 5, "0", STR_PAD_LEFT ).'/'.$arr[1];
} else {
	$leaid = NULL;
}

$username = $tc->belongtostaff->hasmanylogin()->where('active', 1)->first()->username;
?>
		<tr>
			<td>{!! Carbon::parse($tc->date)->format('D, j M Y') !!}</td>
			<td>{!! $tc->belongtostaff->belongtolocation->location !!}</td>
			<td>{!! $username !!}</td>
			<td>{!! $tc->belongtostaff->name !!}</td>
			<td>{{ $tc->daytype }}</td>
			<td>{!! $in1 !!}</td>
			<td>{!! ($tc->break == '00:00:00')?NULL:$break->format('h:i a') !!}</td>
			<td>{!! ($tc->resume == '00:00:00')?NULL:$resume->format('h:i a') !!}</td>
			<td>{!! $out1 !!}</td>
			<td>{!! $tc->work_hour !!}</td>
			<td>{!! ($tc->short_hour > 0)?'<span class="text-danger">'.$tc->short_hour.'</span>':$tc->short_hour !!}</td>
			<td>{!! $ot !!}</td>
			<td>{!! $tc->leave_taken !!}</td>
			<td>{!! $tc->remark !!}</td>
			<td>{!! $leaid !!}</td>
			<td>{!! (is_null($tc->exception) || $tc->exception == 0)?'<i class="fas fa-times"></i>':'<i class="fas fa-check"></i>' !!}</td>
			<td>
				<a href="{!! route('staffTCMS.edit', [$tc->staff_id, 'date' => $tc->date]) !!}" class="btn btn-primary"><i class="far fa-edit"></i></a>
			</td>
		</tr>
@endif
@endforeach
	</tbody>
</table>
	</div>
</div>