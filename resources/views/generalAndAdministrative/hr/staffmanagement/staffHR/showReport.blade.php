@extends('layouts.app')
<?php
use App\Model\StaffLeave;
use App\Model\HolidayCalendar;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

$n = Carbon::now();
$dn = $n->today();
// echo $dn.' today<br />';
$leaveALMC = $staffHR->hasmanystaffannualmcleave()->where('year', date('Y'))->first();
?>

@section('content')
<div class="card">
	<div class="card-header"><h1>Human Resource Department</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<ul class="nav nav-tabs">
@foreach( App\Model\Division::find(1)->hasmanydepartment()->whereNotIn('id', [22, 23, 24])->get() as $key)
			<li class="nav-item">
				<a class="nav-link {{ ($key->id == 3)? 'active' : 'disabled' }}" href="{{ route("$key->route.index") }}">{{ $key->department }}</a>
			</li>
@endforeach
		</ul>

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link " href="{{ route('hrSettings.index') }}">Settings</a>
			</li>
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('staffManagement.index') }}">Staff Management</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('leaveEditing.index') }}">Leave</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('tcms.index') }}">TCMS</a>
			</li>
		</ul>

		<div class="card">
			<div class="card-header">Staff Management</div>
			<div class="card-body">

				<div class="card">
					<div class="card-header">
						<h1>{{ $staffHR->name }} Reports</h1>
					</div>
					<div class="card-body">

						<div class="container table-responsive">
							<div class="row">
								<div class="col-sm-3"><img class="card-img-top figure-img img-fluid rounded" src="{{ asset('storage/'.$staffHR->image) }}" alt="{{ $staffHR->name }} Image"></div>
								<div class="col-sm-9">
									<div class="container">
										<div class="row">

											<dl class="row">
												<dt class="col-sm-3">Staff ID</dt>
												<dd class="col-sm-9">{{ $staffHR->hasmanylogin()->where('active', 1)->first()->username }}</dd>

												<dt class="col-sm-3">Tahun </dt>
												<dd class="col-sm-9">{{ $dn->startofYear()->format('Y') }}</dd>

												<dt class="col-sm-3"><h5>Annual Leave :</h5></dt>
												<dd class="col-sm-9">
													<dl class="row">
														<dt class="col-sm-3">Initialize : </dt>
														<dd class="col-sm-9">{{ $leaveALMC->annual_leave + $leaveALMC->annual_leave_adjustment }} days</dd>
														<dt class="col-sm-3">Balance :</dt>
														<dd class="col-sm-9">
															<span class=" {{ ($leaveALMC->annual_leave_balance < 4)?'text-danger font-weight-bold':'' }}">{{ $leaveALMC->annual_leave_balance }} days</span>
														</dd>
														<dt class="col-sm-3">Utilize : </dt>
														<dd class="col-sm-9">{{ ($leaveALMC->annual_leave + $leaveALMC->annual_leave_adjustment) - ($leaveALMC->annual_leave_balance) }} days</dd>
													</dl>
												</dd>

												<dt class="col-sm-3"><h5>MC Leave :</h5></dt>
												<dd class="col-sm-9">
													<dl class="row">
														<dt class="col-sm-3">Initialize :</dt>
														<dd class="col-sm-9">{{ $leaveALMC->medical_leave + $leaveALMC->medical_leave_adjustment }} days</dd>
														<dt class="col-sm-3">Balance :</dt>
														<dd class="col-sm-9"><span class=" {{ ($leaveALMC->medical_leave_balance < 4)?'text-danger font-weight-bold':'' }}">{{ $leaveALMC->medical_leave_balance }} days</span></dd>
														<dt class="col-sm-3">Utilize :</dt>
														<dd class="col-sm-9">{{ ($leaveALMC->medical_leave + $leaveALMC->medical_leave_adjustment) - ($leaveALMC->medical_leave_balance) }} days</dd>
													</dl>
												</dd>
												<dt class="col-sm-3"><h5>Unpaid MC Leave :</h5></dt>
												<dd class="col-sm-9">{{ $staffHR->hasmanystaffleave()->whereYear( 'date_time_start', date('Y') )->where('leave_id', 11)->get()->sum('period') }} days</dd>
@if( $staffHR->gender_id == 2 )
												<dt class="col-sm-3 text-truncate"><h5>Maternity Leave :</h5></dt>
												<dd class="col-sm-9">
													<dl class="row">
														<dt class="col-sm-3">Initialize :</dt>
														<dd class="col-sm-9">{{ $leaveALMC->maternity_leave + $leaveALMC->maternity_leave_adjustment }} days</dd>
														<dt class="col-sm-3">Balance :</dt>
														<dd class="col-sm-9"><span class=" {{ ($leaveALMC->maternity_leave_balance < 4)?'text-danger font-weight-bold':'' }}">{{ $leaveALMC->maternity_leave_balance }} days</span></dd>
														<dt class="col-sm-3">Utilize :</dt>
														<dd class="col-sm-9">{{ ($leaveALMC->maternity_leave + $leaveALMC->maternity_leave_adjustment) - ($leaveALMC->maternity_leave_balance) }} days</dd>
													</dl>
												</dd>
@endif
												<dt class="col-sm-3"><h5>Unpaid Leave Utilize :</h5></dt>
												<dd class="col-sm-9">{{ $staffHR->hasmanystaffleave()->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [3, 6])->whereIn('active', [1, 2])->get()->sum('period') }} days</dd>
<?php
$oi = $staffHR->hasmanystaffleavereplacement()->where('leave_balance', '<>', 0)->get();
?>
@if($oi->sum('leave_balance') > 0)
												<dt class="col-sm-3"><h5>Non Replacement Leave (Cuti Ganti) :</h5></dt>
												<dd class="col-sm-9">{{ $oi->sum('leave_balance') }} days</dd>
@endif
												<dt class="col-sm-3"><h5>Tidak Hadir (ABSENT) :</h5></dt>
												<dd class="col-sm-9">
<?php
	$absent = $staffHR->hasmanystafftcms()->where('leave_taken', 'ABSENT')->whereBetween('date', [$dn->copy()->startOfYear()->format('Y-m-d'), $n->copy()->format('Y-m-d')])->whereNull('exception')->get();

			$b = 0;
	foreach($absent as $ab) {
		$lea1 = $staffHR->hasmanystaffleave()->whereRaw('"'.$ab->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->whereIn('active', [1, 2])->first();

		// all of this are for checking sunday and holiday
		$hol = [];
		// echo $tc->date.' date<br />';
		if( Carbon::parse($ab->date)->dayOfWeek != 0 ) {
			// echo $tc->date.' kerja <br />';
			$cuti = HolidayCalendar::all();
			foreach ($cuti as $cu) {
				$co = CarbonPeriod::create($cu->date_start, '1 days', $cu->date_end);
				// echo $co.' array or string<br />';
				foreach ($co as $key) {
					if (Carbon::parse($key)->format('Y-m-d') == $ab->date) {
						$hol[Carbon::parse($key)->format('Y-m-d')] = 'a';
						// echo $key.' key<br />';
					}
				}
			}
			if( !array_has($hol, $ab->date) ) {
				if( $ab->leave_taken == 'ABSENT' && is_null($lea1) ) {
					$b++;
				}
			}
		}
	}

	echo $b;
?>
													 days
												</dd>
											</dl>


										</div>
									</div>
								</div>
							</div>
						</div>

						<p>&nbsp;</p>
						<h4>Active And Close Status Leave List</h4>
						<table class="table table-hover table-sm" id="leaves" style="font-size:12px">
							<thead>
								<tr>
									<th rowspan="2">HR Ref</th>
									<th rowspan="2">Leave</th>
									<th rowspan="2">Period</th>
									<th rowspan="2">Apply On</th>
									<th colspan="2">Date/Time Leave</th>
									<th rowspan="2">Reason</th>
									<th colspan="2">Backup</th>
									<th colspan="2">Approval</th>
									<th rowspan="2">Status</th>
								</tr>
								<tr>
									<th>Start</th>
									<th>End</th>
									<th>Backup</th>
									<th>Status</th>
									<th>Approval</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
<?php
$sl = $staffHR->hasmanystaffleave()->where('date_time_start', '>=', $dn->startofYear()->format('Y-m-d'))->where('date_time_end', '<=', $dn->endOfYear()->format('Y-m-d'))->whereNotIn('active', [3, 4])->get();
?>
@foreach($sl as $sd)
<?php
$dts = \Carbon\Carbon::parse($sd->created_at)->format('Y');
$arr = str_split( $dts, 2 );


if ( ($sd->leave_id == 9) || ($sd->leave_id != 9 && $sd->half_day == 2) ) {
	$dts = \Carbon\Carbon::parse($sd->date_time_start)->format('D, j M Y g:i a');
	$dte = \Carbon\Carbon::parse($sd->date_time_end)->format('D, j M Y g:i a');
	if( ($sd->leave_id != 9 && $sd->half_day == 2 && $sd->active == 1) ) {
		if ($sd->leave_id != 9 && $sd->half_day == 2 && $sd->active != 1) {
			$dper = '0 Day';
		} else {
			$dper = 'Half Day';
		}
	} else {
		$i = $sd->period;
				$hour = floor($i/60);
				$minute = ($i % 60);
		$dper = $hour.' hours '.$minute.' minutes';
	}
} else {
	$dts = \Carbon\Carbon::parse($sd->date_time_start)->format('D, j M Y ');
	$dte = \Carbon\Carbon::parse($sd->date_time_end)->format('D, j M Y ');
	$dper = $sd->period.' day/s';
}


// determining backup
$usergroup = $sd->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
$userneedbackup = $sd->belongtostaff->leave_need_backup;
if( !empty($sd->hasonestaffleavebackup) ) {
	$officer = $sd->hasonestaffleavebackup->belongtostaff->name;
	if( $sd->hasonestaffleavebackup->acknowledge === NULL ) {
		$stat = 'Pending';
	}
	if($sd->hasonestaffleavebackup->acknowledge === 1) {
		$stat = 'Approve';
	}
	if($sd->hasonestaffleavebackup->acknowledge === 0) {
		$stat = 'Reject';
	}
} else {
	$officer = 'No Backup';
	$stat = 'No Backup';
}
?>
								<tr>
									<td>HR9-{{ str_pad( $sd->leave_no, 5, "0", STR_PAD_LEFT ) }}/{{ $arr[1] }}</td>
									<td>{{ $sd->belongtoleave->leave }}</td>
									<td>{{ $dper }}</td>
									<td>{{ Carbon::parse($sd->created_at)->format('D, j M Y') }}</td>
									<td>{{ $dts }}</td>
									<td>{{ $dte }}</td>
									<td>{{ $sd->reason }}</td>
									<td>{{ $officer }}</td>
									<td>{{ $stat }}</td>
									<td>
										<table class="table table-hover">
											<tbody>
@foreach( $sd->hasmanystaffapproval()->get() as $appr )
												<tr>
													<td>{{ $appr->belongtostaff->name }}</td>
													<td>{{ ( !isset($appr->approval) )?'Pending':(($appr->approval === 1)?'Approve':'Reject') }}</td>
													<td>{{ Carbon::parse($appr->updated_at)->format('D, j M Y g:i A') }}</td>
												</tr>
@endforeach
											</tbody>
										</table>
									</td>
									<td>{{ $sd->belongtoleavestatus->leave }}</td>
									<td>{{ $sd->belongtoleavestatus->status }}</td>
								</tr>
@endforeach
							</tbody>
						</table>

						<p>&nbsp;</p>
						<h4>Reject And Cancelled Status Leave List</h4>
						<table class="table table-hover table-sm" id="rejncan" style="font-size:12px">
							<thead>
								<tr>
									<th rowspan="2">HR Ref</th>
									<th rowspan="2">Leave</th>
									<th rowspan="2">Period</th>
									<th rowspan="2">Apply On</th>
									<th colspan="2">Date/Time Leave</th>
									<th rowspan="2">Reason</th>
									<th colspan="2">Backup</th>
									<th colspan="2">Approval</th>
									<th rowspan="2">Status</th>
								</tr>
								<tr>
									<th>Start</th>
									<th>End</th>
									<th>Backup</th>
									<th>Status</th>
									<th>Approval</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
<?php
$sl1 = $staffHR->hasmanystaffleave()->where('date_time_start', '>=', $dn->startofYear()->format('Y-m-d'))->where('date_time_end', '<=', $dn->endOfYear()->format('Y-m-d'))->whereIn('active', [3, 4])->get();
?>
@foreach($sl1 as $sd)
<?php
$dts = \Carbon\Carbon::parse($sd->created_at)->format('Y');
$arr = str_split( $dts, 2 );


if ( ($sd->leave_id == 9) || ($sd->leave_id != 9 && $sd->half_day == 2) ) {
	$dts = \Carbon\Carbon::parse($sd->date_time_start)->format('D, j M Y g:i a');
	$dte = \Carbon\Carbon::parse($sd->date_time_end)->format('D, j M Y g:i a');
	if( ($sd->leave_id != 9 && $sd->half_day == 2 && $sd->active == 1) ) {
		if ($sd->leave_id != 9 && $sd->half_day == 2 && $sd->active != 1) {
			$dper = '0 Day';
		} else {
			$dper = 'Half Day';
		}
	} else {
		$i = $sd->period;
				$hour = floor($i/60);
				$minute = ($i % 60);
		$dper = $hour.' hours '.$minute.' minutes';
	}
} else {
	$dts = \Carbon\Carbon::parse($sd->date_time_start)->format('D, j M Y ');
	$dte = \Carbon\Carbon::parse($sd->date_time_end)->format('D, j M Y ');
	$dper = $sd->period.' day/s';
}


// determining backup
$usergroup = $sd->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
$userneedbackup = $sd->belongtostaff->leave_need_backup;
if( !empty($sd->hasonestaffleavebackup) ) {
	$officer = $sd->hasonestaffleavebackup->belongtostaff->name;
	if( $sd->hasonestaffleavebackup->acknowledge === NULL ) {
		$stat = 'Pending';
	}
	if($sd->hasonestaffleavebackup->acknowledge === 1) {
		$stat = 'Approve';
	}
	if($sd->hasonestaffleavebackup->acknowledge === 0) {
		$stat = 'Reject';
	}
} else {
	$officer = 'No Backup';
	$stat = 'No Backup';
}
?>
								<tr>
									<td>HR9-{{ str_pad( $sd->leave_no, 5, "0", STR_PAD_LEFT ) }}/{{ $arr[1] }}</td>
									<td>{{ $sd->belongtoleave->leave }}</td>
									<td>{{ $dper }}</td>
									<td>{{ Carbon::parse($sd->created_at)->format('D, j M Y') }}</td>
									<td>{{ $dts }}</td>
									<td>{{ $dte }}</td>
									<td>{{ $sd->reason }}</td>
									<td>{{ $officer }}</td>
									<td>{{ $stat }}</td>
									<td>
										<table class="table table-hover">
											<tbody>
@foreach( $sd->hasmanystaffapproval()->get() as $appr )
												<tr>
													<td>{{ $appr->belongtostaff->name }}</td>
													<td>{{ ( !isset($appr->approval) )?'Pending':(($appr->approval === 1)?'Approve':'Reject') }}</td>
													<td>{{ Carbon::parse($appr->updated_at)->format('D, j M Y g:i A') }}</td>
												</tr>
@endforeach
											</tbody>
										</table>
									</td>
									<td>{{ $sd->belongtoleavestatus->leave }}</td>
									<td>{{ $sd->belongtoleavestatus->status }}</td>
								</tr>
@endforeach
							</tbody>
						</table>

						<p>&nbsp;</p>
						<h4>Absent List</h4>
						<table class="table table-hover table-sm" id="absent" style="font-size:12px">
							<thead>
								<tr>
									<th>Date</th>
									<th>Day Type</th>
									<th>In</th>
									<th>Break</th>
									<th>Resume</th>
									<th>Out</th>
									<th>Work Hour</th>
									<th>Short Hour</th>
									<th>Leave Taken</th>
									<th>HR Ref</th>
									<th>Exception</th>
								</tr>
							</thead>
							<tbody>
<?php
// $tcms = $staffHR->hasmanystafftcms()->where('leave_taken', 'ABSENT')->get();
$tcms = $staffHR->hasmanystafftcms()->whereBetween('date', [$dn->copy()->startOfYear()->format('Y-m-d'), $n->copy()->format('Y-m-d')])->whereNULL('exception')->get(); ?>
@foreach($tcms as $tc)
	@if(Carbon::parse($tc->date)->dayOfWeek != 0)
		<?php

		// all of this are for checking sunday and holiday
		$hol = [];
		// echo $tc->date.' date<br />';
		if( Carbon::parse($tc->date)->dayOfWeek != 0 ) {
			// echo $tc->date.' kerja <br />';
			$cuti = HolidayCalendar::all();
			foreach ($cuti as $cu) {
				$co = CarbonPeriod::create($cu->date_start, '1 days', $cu->date_end);
				// echo $co.' array or string<br />';
				foreach ($co as $key) {
					if (Carbon::parse($key)->format('Y-m-d') == $tc->date) {
						$hol[Carbon::parse($key)->format('Y-m-d')] = 'a';
						// echo $key.' key<br />';
					}
				}
			}
		}

		// print_r($hol);
		// echo '<br />';
		// if( array_has($hol, '2018-10-22') ) {
		// 	echo 'success<br />';
		// } else {
		// 	echo 'tak jumpa<br />';
		// }

		$in = Carbon::createFromTimeString($tc->in);
		$break = Carbon::createFromTimeString($tc->break);
		$resume = Carbon::createFromTimeString($tc->resume);
		$out = Carbon::createFromTimeString($tc->out);

		// looking for appropriate leaves for user and the status of the leave is "cancelled" or "rejected"
		$lea = $staffHR->hasmanystaffleave()->whereRaw('"'.$tc->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->whereIn('active', [3, 4])->first();
		// echo $lea.'<br />';

		// looking for appropriate leaves for user and the status of the leave is "active" or "closed"
		$lea1 = $staffHR->hasmanystaffleave()->whereRaw('"'.$tc->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->whereIn('active', [1, 2])->first();

		if ( !empty( $lea ) ) {
			$dts = Carbon::parse($lea->created_at)->format('Y');
			$arr = str_split( $dts, 2 );
			$leaid = 'HR9-'.str_pad( $lea->leave_no, 5, "0", STR_PAD_LEFT ).'/'.$arr[1];
		} else {
			$leaid = NULL;
		}

		if ( !empty( $lea1 ) ) {
			$dts = Carbon::parse($lea1->created_at)->format('Y');
			$arr = str_split( $dts, 2 );
			$leaid1 = 'HR9-'.str_pad( $lea1->leave_no, 5, "0", STR_PAD_LEFT ).'/'.$arr[1];
		} else {
			$leaid1 = NULL;
		}
		?>
		@if( !array_has($hol, $tc->date) )
			@if( $tc->leave_taken == 'ABSENT' && is_null($lea1) )
									<tr>
										<td>{!! Carbon::parse($tc->date)->format('D, j F Y') !!}</td>
										<td>{{ $tc->daytype }}</td>
										<td>{{ ($tc->in == '00:00:00')?NULL:$in->format('h:i a') }}</td>
										<td>{{ ($tc->break == '00:00:00')?NULL:$break->format('h:i a') }}</td>
										<td>{!! ($tc->resume == '00:00:00')?NULL:$resume->format('h:i a') !!}</td>
										<td>{{ ($tc->out == '00:00:00')?NULL:$out->format('h:i a') }}</td>
										<td>{!! $tc->work_hour !!}</td>
										<td>{!! ($tc->short_hour > 0)?'<span class="text-danger">'.$tc->short_hour.'</span>':$tc->short_hour !!}</td>
										<td>{!! $tc->leave_taken !!}</td>
										<td>{!! $leaid !!}&nbsp;{!! $leaid1 !!}</td>
										<td>{!! (is_null($tc->exception) || $tc->exception == 0)?'<i class="fas fa-times"></i>':'<i class="fas fa-check"></i>' !!}</td>
									</tr>
			@endif
		@endif	
	@endif
@endforeach

							</tbody>
						</table>

						<p>&nbsp;</p>
						<h4>Lateness List</h4>
						<table class="table table-hover table-sm" id="late" style="font-size:12px">
							<thead>
								<tr>
									<th>Date</th>
									<th>Day Type</th>
									<th>In</th>
									<th>Break</th>
									<th>Resume</th>
									<th>Out</th>
									<th>Work Hour</th>
									<th>Short Hour</th>
									<th>Leave Taken</th>
									<th>Remarks</th>
									<th>HR Ref</th>
									<th>Exception</th>
								</tr>
							</thead>
							<tbody>
@foreach( $staffHR->hasmanystafftcms()->whereBetween('date', [$dn->copy()->startOfYear()->format('Y-m-d'), $n->copy()->format('Y-m-d')])->get() as $tc )
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

if( $tc->out != '00:00:00' ) {
	if( $out->gte( Carbon::createFromTimeString($time->first()->time_end_pm) ) ) {
		$out1 = '<span class="text-success">'.$out->format('h:i a').'</span>';
	} else {
		$out1 = '<span class="text-danger">'.$out->format('h:i a').'</span>';
	}
} else {
	$out1 = NULL;
}
?>
@if( $in->gt( Carbon::createFromTimeString($time->first()->time_start_am) ) )
								<tr>
									<td>{!! Carbon::parse($tc->date)->format('D, j M Y') !!}</td>
									<td>{{ $tc->daytype }}</td>
									<td>{!! $in1 !!}</td>
									<td>{!! ($tc->break == '00:00:00')?NULL:$break->format('h:i a') !!}</td>
									<td>{!! ($tc->resume == '00:00:00')?NULL:$resume->format('h:i a') !!}</td>
									<td>{!! $out1 !!}</td>
									<td>{!! $tc->work_hour !!}</td>
									<td>{!! ($tc->short_hour > 0)?'<span class="text-danger">'.$tc->short_hour.'</span>':$tc->short_hour !!}</td>
									<td>{!! $tc->leave_taken !!}</td>
									<td>{!! $tc->remark !!}</td>
									<td>{!! $leaid !!}</td>
									<td>{!! (is_null($tc->exception) || $tc->exception == 0)?'<i class="fas fa-times"></i>':'<i class="fas fa-check"></i>' !!}</td>
								</tr>
@endif
@endforeach
							</tbody>
						</table>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$(document).on('keyup', '#hol', function () {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
$.fn.dataTable.moment( 'ddd, D MMM YYYY' );

$('#leaves').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[4, "desc" ]],	// sorting the 6th column descending
	// responsive: true
});

$('#rejncan').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[4, "desc" ]],	// sorting the 6th column descending
	// responsive: true
});

$('#absent').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[0, "desc" ]],	// sorting the 6th column descending
	// responsive: true
});

$('#late').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[0, "desc" ]],	// sorting the 6th column descending
	// responsive: true
});

/////////////////////////////////////////////////////////////////////////////////////////
// delete merit
$(document).on('click', '.disable_user', function(e){
	
	var productId = $(this).data('id');
	SwalDelete(productId);
	e.preventDefault();
});

function SwalDelete(productId){
	swal({
		title: 'Are you sure?',
		text: "It will be deleted permanently!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					type: 'DELETE',
					url: '{{ url('staffHRdiscipline') }}' + '/' + '{{ $staffHR->id }}',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: productId,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#disable_user_' + productId).parent().parent().remove();
				})
				.fail(function(){
					swal('Oops...', 'Something went wrong with ajax !', 'error');
				})
			});
		},
		allowOutsideClick: false			  
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal('Cancelled', 'Your data is safe from delete', 'info')
		}
	});
}



/////////////////////////////////////////////////////////////////////////////////////////
@endsection

