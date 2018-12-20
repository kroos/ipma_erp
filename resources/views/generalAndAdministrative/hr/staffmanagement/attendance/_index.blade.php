<?php
ini_set('max_execution_time', 300); //5 minutes

// load Model
use \App\Model\Staff;
use \App\Model\StaffTCMS;
use \App\Model\StaffLeave;
use \App\Model\StaffAnnualMCLeave;
use \App\Model\WorkingHour;
use \App\Model\Discipline;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

$i1 = 1;
$i2 = 1;
$i2late = 0;

$n = Carbon::now();
?>
<div class="card">
	<div class="card-header">Staff Attendance & Discipline</div>
	<div class="card-body">

		<table class="table table-hover" style="font-size:12px" id="staffdiscoff">
			<thead>
				<tr>
					<th rowspan="2">&nbsp;</th>
					<th rowspan="2">ID Staff</th>
					<th rowspan="2">Name</th>
					<th rowspan="2">Location</th>
					<th rowspan="2">Department</th>
					<th colspan="2" >Late</th>
					<th colspan="2" >Freq. UPL</th>
					<th colspan="2" >Freq MC</th>
					<th colspan="2" >EL w/o Supporting Doc</th>
					<th colspan="2" >Absent / Absent w/ Reject Or Cancelled</th>
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
					<th>Count</th>
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
// echo $sf->id;

$stcms = StaffTCMS::where([['staff_id', $sf->id]])->whereNull('exception')->whereBetween('date', [$n->copy()->startOfYear()->format('Y-m-d'), $n->copy()->format('Y-m-d')])->get();
$i1late = 0;
$count = 0;
$count1 = 0;
$count2 = 0;
foreach ($stcms as $tc) {
		// time constant
	$userposition = $tc->pos_id;
	$dt = Carbon::parse($tc->date);

	if( $userposition != 72 && $dt->dayOfWeek != 5 ) {	// checking for friday
		// normal
		$time = \App\Model\WorkingHour::where('year', $dt->year)->whereRaw('"'.$dt.'" BETWEEN working_hours.effective_date_start AND working_hours.effective_date_end' )->limit(1);
	} elseif( $userposition != 72 && $dt->dayOfWeek == 5 ) {	// checking for friday {
		$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 3)->whereRaw('"'.$dt.'" BETWEEN working_hours.effective_date_start AND working_hours.effective_date_end' )->limit(1);
	}

	$in = Carbon::createFromTimeString($tc->in);

	if( $in->gt( Carbon::createFromTimeString($time->first()->time_start_am) ) ) {
		// now checking if got tf leave form
		$sl = StaffLeave::where([['staff_id', $sf->id], ['leave_id', 9]])->whereIn('active', [1, 2])->whereRaw('"'.$dt->format('Y-m-d').'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->get()->count();

		if ( $sl == 0 ) {
			$i1late++;
		}
	}
}
$lm = Discipline::where('id', 1)->first();
////////////////////////////////////////////////////////////////////////////
// freq UPL
$sl1 = StaffLeave::where('staff_id', $sf->id)->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [3, 6])->whereIn('active', [1, 2])->get()->sum('period');
$lm1 = Discipline::where('id', 2)->first();
////////////////////////////////////////////////////////////////////////////
// freq MC
$sl2 = StaffLeave::where('staff_id', $sf->id)->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [11])->whereIn('active', [1, 2])->get()->sum('period');
$leaveALMC = StaffAnnualMCLeave::where('staff_id', $sf->id)->where('year', date('Y'))->first();
$mc = $sl2 + ($leaveALMC->medical_leave + $leaveALMC->medical_leave_adjustment) - ($leaveALMC->medical_leave_balance);
$lm2 = Discipline::where('id', 3)->first();
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////

?>
				<tr>
					<td>{!! $i1++ !!}</td>
					<td>{!! $sf->username !!}</td>
					<td>{!! $sf->name !!}</td>
					<td>{!! $sf->location !!}</td>
					<td>{!! $sf->department !!}</td>
					<td>{!! $i1late !!}</td>
					<td>{!! $i1late * $lm->merit_point !!}<?php $count += $i1late * $lm->merit_point ?> m</td>
					<td>{!! $sl1 !!}</td>
					<td>{!! $sl1 * $lm1->merit_point  !!}<?php $count1 += $sl1 * $lm1->merit_point ?> m</td>
					<td>{!! $mc !!}</td>
					<td>{!! $mc * $lm2->merit_point !!}<?php $count2 += $mc * $lm2->merit_point ?> m</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>{!! number_format($count + $count1 + $count2 , 2) !!}</td>
				</tr>
@endforeach
			</tbody>
		</table>
<p>&nbsp;</p>
		<table class="table table-hover" style="font-size:12px" id="staffdiscprod">
			<thead>
				<tr>
					<th rowspan="2">&nbsp;</th>
					<th rowspan="2">ID Staff</th>
					<th rowspan="2">Name</th>
					<th rowspan="2">Location</th>
					<th rowspan="2">Department</th>
					<th colspan="2" >Late</th>
					<th colspan="2" >Freq. UPL</th>
					<th colspan="2" >Freq MC</th>
					<th colspan="2" >EL w/o Supporting Doc</th>
					<th colspan="2" >Absent / Absent w/ Reject Or Cancelled</th>
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
					<th>Count</th>
					<th>Merit</th>
					<th>Count</th>
					<th>Merit</th>
				</tr>
			</thead>
			<tbody>
@foreach($st2 as $sf)
<?php
////////////////////////////////////////////////////////////////////////////
// lateness
$stcms = StaffTCMS::where([['staff_id', $sf->id]])->whereNull('exception')->whereBetween('date', [$n->copy()->startOfYear()->format('Y-m-d'), $n->copy()->format('Y-m-d')])->get();
$i1late = 0;
$count = 0;
$count1 = 0;
$count2 = 0;
foreach ($stcms as $tc) {

	$userposition = $tc->pos_id;;
	$dt = Carbon::parse($tc->date);

	if( $userposition == 72 && $dt->dayOfWeek != 5 ) {	// checking for friday
		$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 8);
	} elseif ( $userposition == 72 && $dt->dayOfWeek == 5 ) {	// checking for friday
		$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 8);
	}
	
	$in = Carbon::createFromTimeString($tc->in);
	
	if( $in->gt( Carbon::createFromTimeString($time->first()->time_start_am) ) ) {
		// now checking if got tf leave form
		$sl = StaffLeave::where([['staff_id', $sf->id], ['leave_id', 9]])->whereIn('active', [1, 2])->whereRaw('"'.$dt->format('Y-m-d').'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->get()->count();

		if ( $sl == 0 ) {
			$i1late++;
		}
	}
}
$lm = Discipline::where('id', 1)->first();
////////////////////////////////////////////////////////////////////////////
// freq UPL
$sl1 = StaffLeave::where('staff_id', $sf->id)->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [3, 6])->whereIn('active', [1, 2])->get()->sum('period');
$lm1 = Discipline::where('id', 2)->first();
////////////////////////////////////////////////////////////////////////////
// freq MC
$sl2 = StaffLeave::where('staff_id', $sf->id)->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [11])->whereIn('active', [1, 2])->get()->sum('period');
$leaveALMC = StaffAnnualMCLeave::where('staff_id', $sf->id)->where('year', date('Y'))->first();
$mc = $sl2 + ($leaveALMC->medical_leave + $leaveALMC->medical_leave_adjustment) - ($leaveALMC->medical_leave_balance);
$lm2 = Discipline::where('id', 3)->first();
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////

?>
				<tr>
					<td>{!! $i2++ !!}</td>
					<td>{!! $sf->username !!}</td>
					<td>{!! $sf->name !!}</td>
					<td>{!! $sf->location !!}</td>
					<td>{!! $sf->department !!}</td>
					<td>{!! $i1late !!}</td>
					<td>{!! $i1late * $lm->merit_point !!}<?php $count += $i1late * $lm->merit_point ?> m</td>
					<td>{!! $sl1 !!}</td>
					<td>{!! $sl1 * $lm1->merit_point !!}<?php $count1 += $sl1 * $lm1->merit_point ?> m</td>
					<td>{!! $mc !!}</td>
					<td>{!! $mc * $lm2->merit_point !!}<?php $count2 += $mc * $lm2->merit_point ?> m</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>{!! number_format($count + $count1 + $count2, 2) !!}</td>
				</tr>
@endforeach
			</tbody>
		</table>

	</div>
</div>