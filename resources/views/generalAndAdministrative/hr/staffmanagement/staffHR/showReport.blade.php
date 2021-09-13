@extends('layouts.app')
<?php
ini_set('max_execution_time', 300); //5 minutes

// load Model
use \App\Model\StaffLeave;
use \App\Model\HolidayCalendar;
use \App\Model\StaffTCMS;
use \App\Model\StaffAnnualMCLeave;
use \App\Model\WorkingHour;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

$n = Carbon::now();
$dn = $n->today();
$dn1 = $n->copy()->subYear();
// echo $dn1->format('Y-m-d').' today<br />';


$leaveALMC = $staffHR->hasmanystaffannualmcleave()->where('year', date('Y'))->first();

// tahun lepas
$leaveALMC1 = $staffHR->hasmanystaffannualmcleave()->where('year', $dn1->format('Y'))->first();

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

						<div class="container-fluid table-responsive">
							<div class="row">
								<div class="col-sm-3"><img class="card-img-top figure-img img-fluid rounded" src="{{ asset('storage/'.$staffHR->image) }}" alt="{{ $staffHR->name }} Image"></div>
								<div class="col-sm-9">
									<div class="container-fluid row">
										<div class="col-6">
@if( $staffHR->hasmanystaffannualmcleave()->where('year', $dn1->format('Y'))->get()->count() > 0 )
											<dl class="row">
												<dt class="col-sm-6">Staff ID</dt>
												<dd class="col-sm-6">{{ $staffHR->hasmanylogin()->where('active', 1)->first()->username }}</dd>

												<dt class="col-sm-6">Tahun </dt>
												<dd class="col-sm-6">{{ $dn1->startofYear()->format('Y') }}</dd>

												<dt class="col-sm-6"><h5>Annual Leave :</h5></dt>
												<dd class="col-sm-6">
													<dl class="row">
														<dt class="col-sm-6">Initialize : </dt>
														<dd class="col-sm-6">{{ $leaveALMC1->annual_leave + $leaveALMC1->annual_leave_adjustment }} days</dd>
														<dt class="col-sm-6">Balance :</dt>
														<dd class="col-sm-6">
															<span class=" {{ ($leaveALMC1->annual_leave_balance < 4)?'text-danger font-weight-bold':'' }}">{{ $leaveALMC1->annual_leave_balance }} days</span>
														</dd>
														<dt class="col-sm-6">Utilize : </dt>
														<dd class="col-sm-6">{{ ($leaveALMC1->annual_leave + $leaveALMC1->annual_leave_adjustment) - ($leaveALMC1->annual_leave_balance) }} days</dd>
													</dl>
												</dd>

												<dt class="col-sm-6"><h5>MC Leave :</h5></dt>
												<dd class="col-sm-6">
													<dl class="row">
														<dt class="col-sm-6">Initialize :</dt>
														<dd class="col-sm-6">{{ $leaveALMC1->medical_leave + $leaveALMC1->medical_leave_adjustment }} days</dd>
														<dt class="col-sm-6">Balance :</dt>
														<dd class="col-sm-6"><span class=" {{ ($leaveALMC1->medical_leave_balance < 4)?'text-danger font-weight-bold':'' }}">{{ $leaveALMC1->medical_leave_balance }} days</span></dd>
														<dt class="col-sm-6">Utilize :</dt>
														<dd class="col-sm-6">{{ ($leaveALMC1->medical_leave + $leaveALMC1->medical_leave_adjustment) - ($leaveALMC1->medical_leave_balance) }} days</dd>
													</dl>
												</dd>
												<dt class="col-sm-6"><h5>Unpaid MC Leave :</h5></dt>
												<dd class="col-sm-6">{{ $staffHR->hasmanystaffleave()->whereYear( 'date_time_start', $dn1->format('Y') )->where('leave_id', 11)->get()->sum('period') }} days</dd>
@if( $staffHR->gender_id == 2 )
												<dt class="col-sm-6 text-truncate"><h5>Maternity Leave :</h5></dt>
												<dd class="col-sm-6">
													<dl class="row">
														<dt class="col-sm-6">Initialize :</dt>
														<dd class="col-sm-6">{{ $leaveALMC1->maternity_leave + $leaveALMC1->maternity_leave_adjustment }} days</dd>
														<dt class="col-sm-6">Balance :</dt>
														<dd class="col-sm-6"><span class=" {{ ($leaveALMC1->maternity_leave_balance < 4)?'text-danger font-weight-bold':'' }}">{{ $leaveALMC1->maternity_leave_balance }} days</span></dd>
														<dt class="col-sm-6">Utilize :</dt>
														<dd class="col-sm-6">{{ ($leaveALMC1->maternity_leave + $leaveALMC1->maternity_leave_adjustment) - ($leaveALMC1->maternity_leave_balance) }} days</dd>
													</dl>
												</dd>
@endif
												<dt class="col-sm-6"><h5>Unpaid Leave Utilize :</h5></dt>
												<dd class="col-sm-6">{{ $staffHR->hasmanystaffleave()->whereYear( 'date_time_start', $dn1->format('Y') )->whereIn('leave_id', [3, 6])->whereIn('active', [1, 2])->get()->sum('period') }} days</dd>
<?php
$oi = $staffHR->hasmanystaffleavereplacement()->where('leave_balance', '<>', 0)->get();
?>
@if($oi->sum('leave_balance') > 0)
												<dt class="col-sm-6"><h5>Non Replacement Leave (Cuti Ganti) :</h5></dt>
												<dd class="col-sm-6">{{ $oi->sum('leave_balance') }} days</dd>
@endif
												<dt class="col-sm-6"><h5>Tidak Hadir (ABSENT) :</h5></dt>
												<dd class="col-sm-6">
<?php
////////////////////////////////////////////////////////////////////////////
// absent
// find public holiday
$h1 = HolidayCalendar::whereYear('date_start', $dn1->format('Y') )->get();
$h4 = [];
foreach($h1 as $h2) {
	// echo $h2->date_start.' '.$h2->date_end.' hoilday calendar<br />';
	$h3 = CarbonPeriod::create($h2->date_start, '1 days', $h2->date_end);
	foreach ($h3 as $key => $value) {
		$h5[] = $value->format('Y-m-d');
		// echo $value->format('Y-m-d').' iterate<br />';
	}
}

// checking if the array is correct
// foreach($h4 as $h5){
// 	echo $h5.' iterate h4<br />';
// }

// not working at all
$stcms1 = $staffHR->hasmanystafftcms()->whereNull('exception')->whereBetween('date', [$dn1->copy()->startOfYear()->format('Y-m-d'), $dn1->copy()->endOfYear()->format('Y-m-d')])->where([['in', '00:00:00'], ['break', '00:00:00'], ['resume', '00:00:00'], ['out', '00:00:00'], ['leave_taken', '<>', 'Outstation'], ['daytype', 'WORKDAY'] ])->whereNotIn('date', $h5)->get();

// working in the evening
$stcms2 = $staffHR->hasmanystafftcms()->whereNull('exception')->whereBetween('date', [$dn1->copy()->startOfYear()->format('Y-m-d'), $dn1->copy()->endOfYear()->format('Y-m-d')])->where([['in', '<>', '00:00:00'], ['break', '<>', '00:00:00'], ['resume', '00:00:00'], ['out', '00:00:00'], ['leave_taken', '<>', 'Outstation'], ['daytype', 'WORKDAY'] ])->whereNotIn('date', $h5)->get();

// working in the morning
$stcms3 = $staffHR->hasmanystafftcms()->whereNull('exception')->whereBetween('date', [$dn1->copy()->startOfYear()->format('Y-m-d'), $dn1->copy()->endOfYear()->format('Y-m-d')])->where([['in', '00:00:00'], ['break', '00:00:00'], ['resume', '<>', '00:00:00'], ['out', '<>', '00:00:00'], ['leave_taken', '<>', 'Outstation'], ['daytype', 'WORKDAY'] ])->whereNotIn('date', $h5)->get();
$m = 0;
$v2 = 0;
foreach($stcms1 as $ke) {
	$sl5 = $staffHR->hasmanystaffleave()->whereRaw('"'.$ke->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->get();
	if($sl5->isEmpty()){
		$m = $m+1;
		// echo $m.' count absent<br />';
	} else {
		// echo $sl5.' <br />';
		$v = 0;
		foreach ($sl5 as $nq) {
			$b = 0;
			$p = 0;
			if($nq->active == 1 || $nq->active == 2) {
				$b = 1;
			} else {
				$p = 1;
			}
		}
			$v += $p - $b;
			// echo $v.' absent count<br />';
			if($v == -1) {
				$v1 = 0;
			} else {
				$v1 = $v;
			}
			$v2 += $v1;
			// echo $v2.' v2 absent count<br />';
	}
	// echo $m + $v2.' = m+v2 <br />';
	// echo $ke->name.' '.$ke->date.' '.$ke->in.' '.$ke->break.' '.$ke->resume.' '.$ke->out.' '.$ke->leave_taken.' absent<br />';
	// echo '---------------------------------<br />';
}
echo $m + $v2;
////////////////////////////////////////////////////////////////////////////
?>
													 days
												</dd>
											</dl>
@else
										<p>No Record Last Year</p>
@endif
										</div>
										<div class="col-6">

											<dl class="row">
												<dt class="col-sm-6">Staff ID</dt>
												<dd class="col-sm-6">{{ $staffHR->hasmanylogin()->where('active', 1)->first()->username }}</dd>

												<dt class="col-sm-6">Tahun </dt>
												<dd class="col-sm-6">{{ $dn->startofYear()->format('Y') }}</dd>

												<dt class="col-sm-6"><h5>Annual Leave :</h5></dt>
												<dd class="col-sm-6">
													<dl class="row">
														<dt class="col-sm-6">Initialize : </dt>
														<dd class="col-sm-6">{{ $leaveALMC->annual_leave + $leaveALMC->annual_leave_adjustment }} days</dd>
														<dt class="col-sm-6">Balance :</dt>
														<dd class="col-sm-6">
															<span class=" {{ ($leaveALMC->annual_leave_balance < 4)?'text-danger font-weight-bold':'' }}">{{ $leaveALMC->annual_leave_balance }} days</span>
														</dd>
														<dt class="col-sm-6">Utilize : </dt>
														<dd class="col-sm-6">{{ ($leaveALMC->annual_leave + $leaveALMC->annual_leave_adjustment) - ($leaveALMC->annual_leave_balance) }} days</dd>
													</dl>
												</dd>

												<dt class="col-sm-6"><h5>MC Leave :</h5></dt>
												<dd class="col-sm-6">
													<dl class="row">
														<dt class="col-sm-6">Initialize :</dt>
														<dd class="col-sm-6">{{ $leaveALMC->medical_leave + $leaveALMC->medical_leave_adjustment }} days</dd>
														<dt class="col-sm-6">Balance :</dt>
														<dd class="col-sm-6"><span class=" {{ ($leaveALMC->medical_leave_balance < 4)?'text-danger font-weight-bold':'' }}">{{ $leaveALMC->medical_leave_balance }} days</span></dd>
														<dt class="col-sm-6">Utilize :</dt>
														<dd class="col-sm-6">{{ ($leaveALMC->medical_leave + $leaveALMC->medical_leave_adjustment) - ($leaveALMC->medical_leave_balance) }} days</dd>
													</dl>
												</dd>
												<dt class="col-sm-6"><h5>Unpaid MC Leave :</h5></dt>
												<dd class="col-sm-6">{{ $staffHR->hasmanystaffleave()->whereYear( 'date_time_start', date('Y') )->where('leave_id', 11)->get()->sum('period') }} days</dd>
@if( $staffHR->gender_id == 2 )
												<dt class="col-sm-6 text-truncate"><h5>Maternity Leave :</h5></dt>
												<dd class="col-sm-6">
													<dl class="row">
														<dt class="col-sm-6">Initialize :</dt>
														<dd class="col-sm-6">{{ $leaveALMC->maternity_leave + $leaveALMC->maternity_leave_adjustment }} days</dd>
														<dt class="col-sm-6">Balance :</dt>
														<dd class="col-sm-6"><span class=" {{ ($leaveALMC->maternity_leave_balance < 4)?'text-danger font-weight-bold':'' }}">{{ $leaveALMC->maternity_leave_balance }} days</span></dd>
														<dt class="col-sm-6">Utilize :</dt>
														<dd class="col-sm-6">{{ ($leaveALMC->maternity_leave + $leaveALMC->maternity_leave_adjustment) - ($leaveALMC->maternity_leave_balance) }} days</dd>
													</dl>
												</dd>
@endif
												<dt class="col-sm-6"><h5>Unpaid Leave Utilize :</h5></dt>
												<dd class="col-sm-6">{{ $staffHR->hasmanystaffleave()->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [3, 6])->whereIn('active', [1, 2])->get()->sum('period') }} days</dd>
<?php
$oi = $staffHR->hasmanystaffleavereplacement()->where('leave_balance', '<>', 0)->get();
?>
@if($oi->sum('leave_balance') > 0)
												<dt class="col-sm-6"><h5>Non Replacement Leave (Cuti Ganti) :</h5></dt>
												<dd class="col-sm-6">{{ $oi->sum('leave_balance') }} days</dd>
@endif
												<dt class="col-sm-6"><h5>Tidak Hadir (ABSENT) :</h5></dt>
												<dd class="col-sm-6">
<?php
////////////////////////////////////////////////////////////////////////////
// absent
// find public holiday
$h1 = HolidayCalendar::whereYear('date_start', $n->format('Y'))->get();
$h4 = [];
foreach($h1 as $h2) {
	// echo $h2->date_start.' '.$h2->date_end.' hoilday calendar<br />';
	$h3 = CarbonPeriod::create($h2->date_start, '1 days', $h2->date_end);
	foreach ($h3 as $key => $value) {
		$h4[] = $value->format('Y-m-d');
		// echo $value->format('Y-m-d').' iterate<br />';
	}
}

// checking if the array is correct
// foreach($h4 as $h5){
// 	echo $h5.' iterate h4<br />';
// }

// not working at all
$stcms1 = $staffHR->hasmanystafftcms()->whereNull('exception')->whereBetween('date', [$n->copy()->startOfYear()->format('Y-m-d'), $n->copy()->format('Y-m-d')])->where([['in', '00:00:00'], ['break', '00:00:00'], ['resume', '00:00:00'], ['out', '00:00:00'], ['leave_taken', '<>', 'Outstation'], ['daytype', 'WORKDAY'] ])->whereNotIn('date', $h4)->get();

// working in the evening
$stcms2 = $staffHR->hasmanystafftcms()->whereNull('exception')->whereBetween('date', [$n->copy()->startOfYear()->format('Y-m-d'), $n->copy()->format('Y-m-d')])->where([['in', '<>', '00:00:00'], ['break', '<>', '00:00:00'], ['resume', '00:00:00'], ['out', '00:00:00'], ['leave_taken', '<>', 'Outstation'], ['daytype', 'WORKDAY'] ])->whereNotIn('date', $h4)->get();

// working in the morning
$stcms3 = $staffHR->hasmanystafftcms()->whereNull('exception')->whereBetween('date', [$n->copy()->startOfYear()->format('Y-m-d'), $n->copy()->format('Y-m-d')])->where([['in', '00:00:00'], ['break', '00:00:00'], ['resume', '<>', '00:00:00'], ['out', '<>', '00:00:00'], ['leave_taken', '<>', 'Outstation'], ['daytype', 'WORKDAY'] ])->whereNotIn('date', $h4)->get();
$m = 0;
$v2 = 0;
foreach($stcms1 as $ke) {
	$sl5 = $staffHR->hasmanystaffleave()->whereRaw('"'.$ke->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->get();
	if($sl5->isEmpty()){
		$m = $m+1;
		// echo $m.' count absent<br />';
	} else {
		// echo $sl5.' <br />';
		$v = 0;
		foreach ($sl5 as $nq) {
			$b = 0;
			$p = 0;
			if($nq->active == 1 || $nq->active == 2) {
				$b = 1;
			} else {
				$p = 1;
			}
		}
			$v += $p - $b;
			// echo $v.' absent count<br />';
			if($v == -1) {
				$v1 = 0;
			} else {
				$v1 = $v;
			}
			$v2 += $v1;
			// echo $v2.' v2 absent count<br />';
	}
	// echo $m + $v2.' = m+v2 <br />';
	// echo $ke->name.' '.$ke->date.' '.$ke->in.' '.$ke->break.' '.$ke->resume.' '.$ke->out.' '.$ke->leave_taken.' absent<br />';
	// echo '---------------------------------<br />';
}
echo $m + $v2;
////////////////////////////////////////////////////////////////////////////
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
$dts = \Carbon\Carbon::parse($sd->date_time_start)->format('Y');
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
$dts = \Carbon\Carbon::parse($sd->date_time_start)->format('Y');
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
@foreach($stcms1 as $tc)
	<?php
	$sl5 = $staffHR->hasmanystaffleave()->whereRaw('"'.$tc->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->get();
	?>
	@if( $sl5->isEmpty() )
									<tr>
										<td>{!! Carbon::parse($tc->date)->format('D, j M Y') !!}</td>
										<td>{{ $tc->daytype }}</td>
										<td>{{ $tc->in }}</td>
										<td>{{ $tc->break }}</td>
										<td>{!! $tc->resume !!}</td>
										<td>{{ $tc->out }}</td>
										<td>{!! $tc->work_hour !!}</td>
										<td>{!! ($tc->short_hour > 0)?'<span class="text-danger">'.$tc->short_hour.'</span>':$tc->short_hour !!}</td>
										<td>{!! $tc->leave_taken !!}</td>
										<td>&nbsp;</td>
										<td>{!! (is_null($tc->exception) || $tc->exception == 0)?'<i class="fas fa-times"></i>':'<i class="fas fa-check"></i>' !!}</td>
									</tr>
	@else
		<?php
		$v = 0;
		$dt = NULL;
		foreach($sl5 as $nq1) {
			$t = 0;
			if($nq1->active == 3 || $nq1->active == 4) {
				$t = 1;
			} else {
				$t = 0;
				$dt = $tc->date;
			}
			// echo $dt.' date aprove<br />';
		}
		?>
		@if($tc->date != $dt)
									<tr>
										<td>{!! Carbon::parse($tc->date)->format('D, j M Y') !!}</td>
										<td>{{ $tc->daytype }}</td>
										<td>{{ $tc->in }}</td>
										<td>{{ $tc->break }}</td>
										<td>{!! $tc->resume !!}</td>
										<td>{{ $tc->out }}</td>
										<td>{!! $tc->work_hour !!}</td>
										<td>{!! ($tc->short_hour > 0)?'<span class="text-danger">'.$tc->short_hour.'</span>':$tc->short_hour !!}</td>
										<td>{!! $tc->leave_taken !!}</td>
										<td>
			@if($sl5->count() > 0)
											<table class="table table-hover table-sm" style="font-size:12px">
												<thead>
													<tr>
														<th>HR-Ref</th>
														<th>Status</th>
													</tr>
												</thead>
												<tbody>	
				@foreach($sl5 as $nq)
				<?php
					$dts = Carbon::parse($nq->date_time_start)->format('Y');
					$arr = str_split( $dts, 2 );
					$leaid = 'HR9-'.str_pad( $nq->leave_no, 5, "0", STR_PAD_LEFT ).'/'.$arr[1];
				?>
													<tr>
														<td>{!! $leaid !!}</td>
														<td>{!! ($nq->belongtoleavestatus->status) !!}</td>
													</tr>
				@endforeach
												</tbody>
											</table>
			@endif
										</td>
										<td>{!! (is_null($tc->exception) || $tc->exception == 0)?'<i class="fas fa-times"></i>':'<i class="fas fa-check"></i>' !!}</td>
									</tr>
		@endif
	@endif
@endforeach




<!-- absent in the evening -->
<?php // echo $stcms2; ?>
@foreach($stcms2 as $tc)
	<?php
	$sl5 = $staffHR->hasmanystaffleave()->whereRaw('"'.$tc->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->get();
	?>
	@if( $sl5->isEmpty() )
									<tr>
										<td>{!! Carbon::parse($tc->date)->format('D, j M Y') !!}</td>
										<td>{{ $tc->daytype }}</td>
										<td>{{ $tc->in }}</td>
										<td>{{ $tc->break }}</td>
										<td>{!! $tc->resume !!}</td>
										<td>{{ $tc->out }}</td>
										<td>{!! $tc->work_hour !!}</td>
										<td>{!! ($tc->short_hour > 0)?'<span class="text-danger">'.$tc->short_hour.'</span>':$tc->short_hour !!}</td>
										<td>{!! $tc->leave_taken !!}</td>
										<td>&nbsp;</td>
										<td>{!! (is_null($tc->exception) || $tc->exception == 0)?'<i class="fas fa-times"></i>':'<i class="fas fa-check"></i>' !!}</td>
									</tr>
	@else
		<?php
		$v = 0;
		$dt = NULL;
		foreach($sl5 as $nq1) {
			$t = 0;
			if($nq1->active == 3 || $nq1->active == 4) {
				$t = 1;
			} else {
				$t = 0;
				$dt = $tc->date;
			}
			// echo $dt.' date aprove<br />';
		}
		?>
		@if($tc->date != $dt)
									<tr>
										<td>{!! Carbon::parse($tc->date)->format('D, j M Y') !!}</td>
										<td>{{ $tc->daytype }}</td>
										<td>{{ $tc->in }}</td>
										<td>{{ $tc->break }}</td>
										<td>{!! $tc->resume !!}</td>
										<td>{{ $tc->out }}</td>
										<td>{!! $tc->work_hour !!}</td>
										<td>{!! ($tc->short_hour > 0)?'<span class="text-danger">'.$tc->short_hour.'</span>':$tc->short_hour !!}</td>
										<td>{!! $tc->leave_taken !!}</td>
										<td>
			@if($sl5->count() > 0)
											<table class="table table-hover table-sm" style="font-size:12px">
												<thead>
													<tr>
														<th>HR-Ref</th>
														<th>Status</th>
													</tr>
												</thead>
												<tbody>	
				@foreach($sl5 as $nq)
				<?php
					$dts = Carbon::parse($nq->date_time_start)->format('Y');
					$arr = str_split( $dts, 2 );
					$leaid = 'HR9-'.str_pad( $nq->leave_no, 5, "0", STR_PAD_LEFT ).'/'.$arr[1];
				?>
													<tr>
														<td>{!! $leaid !!}</td>
														<td>{!! ($nq->belongtoleavestatus->status) !!}</td>
													</tr>
				@endforeach
												</tbody>
											</table>
			@endif
										</td>
										<td>{!! (is_null($tc->exception) || $tc->exception == 0)?'<i class="fas fa-times"></i>':'<i class="fas fa-check"></i>' !!}</td>
									</tr>
		@endif
	@endif
@endforeach


<!-- absent in the morning -->
<?php // echo $stcms3; ?>
@foreach($stcms3 as $tc)
	<?php
	$sl5 = $staffHR->hasmanystaffleave()->whereRaw('"'.$tc->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->get();
	?>
	@if( $sl5->isEmpty() )
									<tr>
										<td>{!! Carbon::parse($tc->date)->format('D, j M Y') !!}</td>
										<td>{{ $tc->daytype }}</td>
										<td>{{ $tc->in }}</td>
										<td>{{ $tc->break }}</td>
										<td>{!! $tc->resume !!}</td>
										<td>{{ $tc->out }}</td>
										<td>{!! $tc->work_hour !!}</td>
										<td>{!! ($tc->short_hour > 0)?'<span class="text-danger">'.$tc->short_hour.'</span>':$tc->short_hour !!}</td>
										<td>{!! $tc->leave_taken !!}</td>
										<td>&nbsp;</td>
										<td>{!! (is_null($tc->exception) || $tc->exception == 0)?'<i class="fas fa-times"></i>':'<i class="fas fa-check"></i>' !!}</td>
									</tr>
	@else
		<?php
		$v = 0;
		$dt = NULL;
		foreach($sl5 as $nq1) {
			$t = 0;
			if($nq1->active == 3 || $nq1->active == 4) {
				$t = 1;
			} else {
				$t = 0;
				$dt = $tc->date;
			}
			// echo $dt.' date aprove<br />';
		}
		?>
		@if($tc->date != $dt)
									<tr>
										<td>{!! Carbon::parse($tc->date)->format('D, j M Y') !!}</td>
										<td>{{ $tc->daytype }}</td>
										<td>{{ $tc->in }}</td>
										<td>{{ $tc->break }}</td>
										<td>{!! $tc->resume !!}</td>
										<td>{{ $tc->out }}</td>
										<td>{!! $tc->work_hour !!}</td>
										<td>{!! ($tc->short_hour > 0)?'<span class="text-danger">'.$tc->short_hour.'</span>':$tc->short_hour !!}</td>
										<td>{!! $tc->leave_taken !!}</td>
										<td>
			@if($sl5->count() > 0)
											<table class="table table-hover table-sm" style="font-size:12px">
												<thead>
													<tr>
														<th>HR-Ref</th>
														<th>Status</th>
													</tr>
												</thead>
												<tbody>	
				@foreach($sl5 as $nq)
				<?php
					$dts = Carbon::parse($nq->date_time_start)->format('Y');
					$arr = str_split( $dts, 2 );
					$leaid = 'HR9-'.str_pad( $nq->leave_no, 5, "0", STR_PAD_LEFT ).'/'.$arr[1];
				?>
													<tr>
														<td>{!! $leaid !!}</td>
														<td>{!! ($nq->belongtoleavestatus->status) !!}</td>
													</tr>
				@endforeach
												</tbody>
											</table>
			@endif
										</td>
										<td>{!! (is_null($tc->exception) || $tc->exception == 0)?'<i class="fas fa-times"></i>':'<i class="fas fa-check"></i>' !!}</td>
									</tr>
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

$sl6 = $staffHR->hasmanystaffleave()->whereRaw('"'.$tc->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->get();
$notCount = '';
foreach ($sl6 as $k) {
	if($k->leave_id == 9 && ($k->active == 1 || $k->active ==2)) {
		// echo $k->leave_no.' <br />';
		// echo $tc->date.' <br />';
		$notCount = $tc->date;
	}
}
?>
@if( $in->gt( Carbon::createFromTimeString($time->first()->time_start_am) ) )
@if( $tc->date != $notCount )
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
									<td>
@if($sl6->count() > 0)
										<table class="table table-hover table-sm" style="font-size:12px">
											<thead>
												<tr>
													<th>HR-Ref</th>
													<th>Leave Type</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
@foreach($sl6 as $ty)
<?php
	$dts1 = Carbon::parse($ty->date_time_start)->format('Y');
	$arr = str_split( $dts1, 2 );
	$leaid1 = 'HR9-'.str_pad( $ty->leave_no, 5, "0", STR_PAD_LEFT ).'/'.$arr[1];
?>
												<tr>
													<td>{!! $leaid1 !!}</td>
													<td>{!! $ty->belongtoleave->leave !!}</td>
													<td>{!! $ty->belongtoleavestatus->status !!}</td>
												</tr>
@endforeach
											</tbody>
										</table>
@endif
									</td>
									<td>{!! (is_null($tc->exception) || $tc->exception == 0)?'<i class="fas fa-times"></i>':'<i class="fas fa-check"></i>' !!}</td>
								</tr>
@endif
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
	swal.fire({
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
					swal.fire('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#disable_user_' + productId).parent().parent().remove();
				})
				.fail(function(){
					swal.fire('Oops...', 'Something went wrong with ajax !', 'error');
				})
			});
		},
		allowOutsideClick: false			  
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal.fire('Cancelled', 'Your data is safe from delete', 'info')
		}
	});
}



/////////////////////////////////////////////////////////////////////////////////////////
@endsection

