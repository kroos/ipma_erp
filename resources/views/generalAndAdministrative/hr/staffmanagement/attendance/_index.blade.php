<?php
ini_set('max_execution_time', 300); //5 minutes

// load Model
use \App\Model\Staff;
use \App\Model\StaffTCMS;
use \App\Model\StaffLeave;
use \App\Model\StaffAnnualMCLeave;
use \App\Model\HolidayCalendar;
use \App\Model\WorkingHour;
use \App\Model\Discipline;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

$n = Carbon::now();


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


?>
<div class="card">
	<div class="card-header">Staff Attendance & Discipline</div>
	<div class="card-body">

		<table class="table table-hover table-sm" style="font-size:12px" id="staffdiscoff">
			<thead>
				<tr>
					<th colspan="18" class="text-center text-primary">Office</th>
				</tr>
				<tr>
					<th rowspan="2">ID Staff</th>
					<th rowspan="2">Name</th>
					<th rowspan="2">Location</th>
					<th rowspan="2">Department</th>
					<th colspan="2" >Late</th>
					<th colspan="2" >Freq. UPL</th>
					<th colspan="2" >Freq MC</th>
					<th colspan="2" >EL w/o Supporting Doc</th>
					<th colspan="3" >Absent / Absent w/ Reject Or Cancelled</th>
					<th colspan="2" >EL (Below Than 3 Days)</th>
					<th rowspan="2">Total Merit</th>
				</tr>
				<tr>
					<th>Count</th>
					<th>Merit</th>
					<th>Count</th>
					<th>Merit</th>
					<th>Count</th>
					<th>Merit</th>
					<th>Count</th>
					<th>Merit</th>
					<th>Absent Count</th>
					<th>Absent w/ Reject Count</th>
					<th>Merit</th>
					<th>Count</th>
					<th>Merit</th>
				</tr>
			</thead>
			<tbody>
@foreach($st1 as $sf)
<?php
////////////////////////////////////////////////////////////////////////////
// lateness
// echo $sf->id.' start moola<br />';

$stcms = StaffTCMS::where([['staff_id', $sf->id]])->whereNull('exception')->whereBetween('date', [$n->copy()->startOfYear()->format('Y-m-d'), $n->copy()->format('Y-m-d')])->whereNotIn('date', $h4)->get();
$i1late = 0;
$count = 0;
$count1 = 0;
$count2 = 0;
$count3 = 0;
$count4 = 0;
foreach ($stcms as $tc) {
		// time constant
	$userposition = $tc->pos_id;
	$dt = Carbon::parse($tc->date);

	if( $userposition == 72 && $dt->dayOfWeek != 5 ) {	// checking for friday
		$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 8);
	} else {
		if ( $userposition == 72 && $dt->dayOfWeek == 5 ) {	// checking for friday
			$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 8);
		} else {
			if( $userposition != 72 && $dt->dayOfWeek != 5 ) {	// checking for friday
				// normal
				$time = \App\Model\WorkingHour::where('year', $dt->year)->whereRaw('"'.$dt.'" BETWEEN working_hours.effective_date_start AND working_hours.effective_date_end' )->limit(1);
			} else {
				if( $userposition != 72 && $dt->dayOfWeek == 5 ) {	// checking for friday
					$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 3)->whereRaw('"'.$dt.'" BETWEEN working_hours.effective_date_start AND working_hours.effective_date_end' )->limit(1);
				}
			}
		}
	}

	$in = Carbon::createFromTimeString($tc->in);

	if( $in->gt( Carbon::createFromTimeString($time->first()->time_start_am) ) ) {
		// now checking if got tf leave form
		$sl = StaffLeave::where([['staff_id', $sf->id], ['leave_id', 9]])->whereIn('active', [1, 2])->whereRaw('"'.$dt->format('Y-m-d').'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->get()->count();

		if ( $sl == 0 ) {
			$i1late++;
		}
	}
////////////////////////////////////////////////////////////////////////////
	// Absent / Absent w/ Reject Or Cancelled
	if($tc->in == '00:00:00' && $tc->break == '00:00:00' && $tc->resume == '00:00:00' && $tc->out == '00:00:00' && $tc->leave_taken != 'Outstation') {
		$sl5 = StaffLeave::where([['staff_id', $tc->staff_id]])->whereRaw('"'.$tc->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->get();
	}
}
$lm = Discipline::where('id', 1)->first();
////////////////////////////////////////////////////////////////////////////
// freq UPL
$sl1 = StaffLeave::where('staff_id', $sf->id)->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [3, 6])->whereIn('active', [1, 2])->get()->sum('period');
$lm1 = Discipline::where('id', 2)->first();
if($sl1 < 5){
	$sl1m = 0;
} elseif ($sl1 >= 5 && $sl1 < 10) {
	$sl1m = 1;
} elseif ($sl1 >= 10) {
	$sl1m = 2;
} else {
			$sl1m = 3;
}
////////////////////////////////////////////////////////////////////////////
// freq MC
$sl2 = StaffLeave::where('staff_id', $sf->id)->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [11])->whereIn('active', [1, 2])->get()->sum('period');
$leaveALMC = StaffAnnualMCLeave::where('staff_id', $sf->id)->where('year', date('Y'))->first();
$mc = $sl2 + ($leaveALMC->medical_leave + $leaveALMC->medical_leave_adjustment) - ($leaveALMC->medical_leave_balance);
$lm2 = Discipline::where('id', 3)->first();
if($mc < 8){
	$mcm = 0;
} elseif ($mc >= 8 && $mc < 14) {
	$mcm = 1;
} elseif ($mc >= 14) {
	$mcm = 2;
}
////////////////////////////////////////////////////////////////////////////
// EL w/o Supporting Doc
$sl3 = StaffLeave::where('staff_id', $sf->id)->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [5, 6])->whereIn('active', [1, 2])->whereNull('document')->whereNull('hardcopy')->get()->count();
$lm3 = Discipline::where('id', 4)->first();
////////////////////////////////////////////////////////////////////////////
// EL (Below Than 3 Days)
$sl4 = StaffLeave::where('staff_id', $sf->id)->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [5, 6])->whereIn('active', [1, 2])->get()->count();
$lm4 = Discipline::where('id', 7)->first();
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

$stcms1 = StaffTCMS::where([['staff_id', $sf->id]])->whereNull('exception')->whereBetween('date', [$n->copy()->startOfYear()->format('Y-m-d'), $n->copy()->format('Y-m-d')])->where([['in', '00:00:00'], ['break', '00:00:00'], ['resume', '00:00:00'], ['out', '00:00:00'], ['leave_taken', '<>', 'Outstation'], ['daytype', 'WORKDAY'] ])->whereNotIn('date', $h4)->get();
$m = 0;
$v2 = 0;
foreach($stcms1 as $ke) {
	$sl5 = StaffLeave::where([['staff_id', $ke->staff_id]])->whereRaw('"'.$ke->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->get();
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
$lm5 = Discipline::where('id', 5)->first();
////////////////////////////////////////////////////////////////////////////
?>
				<tr>
					<td>{!! $sf->username !!}</td>
					<td>{!! $sf->name !!}</td>
					<td>{!! $sf->location !!}</td>
					<td>{!! $sf->department !!}</td>
					<td>{!! $i1late !!}</td>
					<td>{!! $i1late * $lm->merit_point !!}<?php $count += $i1late * $lm->merit_point ?> m</td>
					<td>{!! $sl1 !!}</td>
					<td>{!! $sl1m  !!}<?php $count1 += $sl1m ?> m</td>
					<td>{!! $mc !!}</td>
					<td>{!! $mcm !!}<?php $count2 += $mcm ?> m</td>
					<td>{!! $sl3 !!}</td>
					<td>{!! $sl3 * $lm3->merit_point !!}<?php $count3 = $sl3 * $lm3->merit_point ?> m</td>
					<td>{!! $m + $v2 !!}</td>
					<td>{!! $v2 !!}</td>
					<td>{!! ($m + $v2) * $lm5->merit_point !!}<?php $count5 = ($m + $v2) * $lm5->merit_point ?> m</td>
					<td>{!! $sl4 !!}</td>
					<td>{!! $sl4 * $lm4->merit_point !!}<?php $count4 = $sl4 * $lm4->merit_point ?> m</td>
					<td>{!! number_format($count + $count1 + $count2 + $count3 + $count4 , 2) !!}</td>
				</tr>
@endforeach
			</tbody>
		</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
		<table class="table table-hover table-sm" style="font-size:12px" id="staffdiscprod">
			<thead>
				<tr>
					<th colspan="18" class="text-center text-primary">Production</th>
				</tr>
				<tr>
					<th rowspan="2">ID Staff</th>
					<th rowspan="2">Name</th>
					<th rowspan="2">Location</th>
					<th rowspan="2">Department</th>
					<th colspan="2" >Late</th>
					<th colspan="2" >Freq. UPL</th>
					<th colspan="2" >Freq MC</th>
					<th colspan="2" >EL w/o Supporting Doc</th>
					<th colspan="3" >Absent / Absent w/ Reject Or Cancelled</th>
					<th colspan="2" >EL (Below Than 3 Days)</th>
					<th rowspan="2">Total Merit</th>
				</tr>
				<tr>
					<th>Count</th>
					<th>Merit</th>
					<th>Count</th>
					<th>Merit</th>
					<th>Count</th>
					<th>Merit</th>
					<th>Count</th>
					<th>Merit</th>
					<th>Absent Count</th>
					<th>Absent w/ Reject Count</th>
					<th>Merit</th>
					<th>Count</th>
					<th>Merit</th>
				</tr>
			</thead>
			<tbody>
<!-- geng production -->
<!-- $sf = id staff -->
@foreach($st2 as $sf)
<?php
////////////////////////////////////////////////////////////////////////////
// lateness
$stcms = StaffTCMS::where([['staff_id', $sf->id]])->whereNull('exception')->whereBetween('date', [$n->copy()->startOfYear()->format('Y-m-d'), $n->copy()->format('Y-m-d')])->get();
$i1late = 0;
$i2late = 1;
$count = 0;
$count1 = 0;
$count2 = 0;
$count3 = 0;
$count4 = 0;
foreach ($stcms as $tc) {

	$userposition = $tc->pos_id;;
	$dt = Carbon::parse($tc->date);

	if( $userposition == 72 && $dt->dayOfWeek != 5 ) {	// checking for friday
		$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 8);
	} else {
		if ( $userposition == 72 && $dt->dayOfWeek == 5 ) {	// checking for friday
			$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 8);
		} else {
			if( $userposition != 72 && $dt->dayOfWeek != 5 ) {	// checking for friday
				// normal
				$time = \App\Model\WorkingHour::where('year', $dt->year)->whereRaw('"'.$dt.'" BETWEEN working_hours.effective_date_start AND working_hours.effective_date_end' )->limit(1);
			} else {
				if( $userposition != 72 && $dt->dayOfWeek == 5 ) {	// checking for friday
					$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 3)->whereRaw('"'.$dt.'" BETWEEN working_hours.effective_date_start AND working_hours.effective_date_end' )->limit(1);
				}
			}
		}
	}

	$in = Carbon::createFromTimeString($tc->in);
	// echo $time->first()->time_start_am.' time start <br />';
	
	if( $in->gt( Carbon::createFromTimeString($time->first()->time_start_am) ) ) {
		// now checking if got tf leave form
		$sl = StaffLeave::where([['staff_id', $sf->id], ['leave_id', 9]])->whereIn('active', [1, 2])->whereRaw('"'.$dt->format('Y-m-d').'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->get()->count();
		$sl6 = Staff::find($sf->id)->hasmanystaffleave()->whereRaw('"'.$tc->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->get();

		if ( $sl == 0 ) {
			$i1late++;
		}
		$notCount = NULL;
		foreach ($sl6 as $k) {
			if($k->leave_id == 9 && ($k->active == 1 || $k->active ==2)) {
				// echo $k->leave_no.' <br />';
				// echo $tc->date.' <br />';
				$notCount = $tc->date;
			}
		}
		if ($tc->date != $notCount) {
			$i2late++.' late with filter (got TF)<br />';
		}
	}
}
$lm = Discipline::where('id', 1)->first();
////////////////////////////////////////////////////////////////////////////
// freq UPL
$sl1 = StaffLeave::where('staff_id', $sf->id)->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [3, 6])->whereIn('active', [1, 2])->get()->sum('period');
$lm1 = Discipline::where('id', 2)->first();
if($sl1 < 5){
	$sl1m = 0;
} elseif ($sl1 >= 5 && $sl1 < 10) {
	$sl1m = 1;
} elseif ($sl1 >= 10) {
	$sl1m = 2;
}
////////////////////////////////////////////////////////////////////////////
// freq MC
$sl2 = StaffLeave::where('staff_id', $sf->id)->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [11])->whereIn('active', [1, 2])->get()->sum('period');
$leaveALMC = StaffAnnualMCLeave::where('staff_id', $sf->id)->where('year', date('Y'))->first();
$mc = $sl2 + ($leaveALMC->medical_leave + $leaveALMC->medical_leave_adjustment) - ($leaveALMC->medical_leave_balance);
$lm2 = Discipline::where('id', 3)->first();
if($mc < 8){
	$mcm = 0;
} elseif ($mc >= 8 && $mc < 14) {
	$mcm = 1;
} elseif ($mc >= 14) {
	$mcm = 2;
}
////////////////////////////////////////////////////////////////////////////
// EL w/o Supporting Doc
$sl3 = StaffLeave::where('staff_id', $sf->id)->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [5, 6])->whereIn('active', [1, 2])->whereNull('document')->whereNull('hardcopy')->get()->count();
$lm3 = Discipline::where('id', 4)->first();
////////////////////////////////////////////////////////////////////////////
// EL (Below Than 3 Days)
$sl4 = StaffLeave::where('staff_id', $sf->id)->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [5, 6])->whereIn('active', [1, 2])->get()->count();
$lm4 = Discipline::where('id', 7)->first();
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

$stcms1 = StaffTCMS::where([['staff_id', $sf->id]])->whereNull('exception')->whereBetween('date', [$n->copy()->startOfYear()->format('Y-m-d'), $n->copy()->format('Y-m-d')])->where([['in', '00:00:00'], ['break', '00:00:00'], ['resume', '00:00:00'], ['out', '00:00:00'], ['leave_taken', '<>', 'Outstation'], ['daytype', 'WORKDAY'] ])->whereNotIn('date', $h4)->get();
$m = 0;
$v2 = 0;
foreach($stcms1 as $ke) {
	$sl5 = StaffLeave::where([['staff_id', $ke->staff_id]])->whereRaw('"'.$ke->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->get();
	if($sl5->isEmpty()){
		$m = $m+1;
		// echo $m.' count absent<br />';
	} else {
		// echo $sl5.' <br />';
		$v = 0;
		foreach ($sl5 as $nq) {
			$b = 0;
			$p = 0;
			if($nq->active == 1) {
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
$lm5 = Discipline::where('id', 5)->first();
?>
				<tr>
					<td>{!! $sf->username !!}</td>
					<td>{!! $sf->name !!}</td>
					<td>{!! $sf->location !!}</td>
					<td>{!! $sf->department !!}</td>
					<td>{!! $i1late !!}</td>
					<td>{!! $i1late * $lm->merit_point !!}<?php $count += $i1late * $lm->merit_point ?> m</td>
					<td>{!! $sl1 !!}</td>
					<td>{!! $sl1m !!}<?php $count1 += $sl1m ?> m</td>
					<td>{!! $mc !!}</td>
					<td>{!! $mcm !!}<?php $count2 += $mcm ?> m</td>
					<td>{!! $sl3 !!}</td>
					<td>{!! $sl3 * $lm3->merit_point !!}<?php $count3 = $sl3 * $lm3->merit_point ?> m</td>
					<td>{!! $m + $v2 !!}</td>
					<td>{!! $v2 !!}</td>
					<td>{!! ($m + $v2) * $lm5->merit_point !!}<?php $count5 = ($m + $v2) * $lm5->merit_point ?> m</td>
					<td>{!! $sl4 !!}</td>
					<td>{!! $sl4 * $lm4->merit_point !!}<?php $count4 = $sl4 * $lm4->merit_point ?> m</td>
					<td>{!! number_format($count + $count1 + $count2 + $count3 + $count4 + $count5, 2) !!}</td>
				</tr>
@endforeach
			</tbody>
		</table>

	</div>
</div>