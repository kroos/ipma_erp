<?php
ini_set('max_execution_time', 300); //5 minutes

use \App\Model\Staff;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

$i1 = 1;
$i2 = 1;
$i1late = 0;
$i2late = 0;

$n = Carbon::now();
$dn = $n->today();
// echo $dn.' today<br />';
// $leaveALMC = $staffHR->hasmanystaffannualmcleave()->where('year', date('Y'))->first();

$st = Staff::where('active', 1)->whereNotIn('id', [191, 192])->get();
// ->belongtomanyposition()->wherePivot('main', 1)->first();
?>
<div class="card">
	<div class="card-header">Staff Attendance & Discipline</div>
	<div class="card-body">

		<table class="table table-hover" style="font-size:12px" id="staffdiscoff">
			<thead>
				<tr>
					<th>&nbsp;</th>
					<th>ID Staff</th>
					<th>Name</th>
					<th>Location</th>
					<th>Department</th>
					<th colspan="2" >Late</th>
					<th colspan="2" >Freq. UPL</th>
					<th colspan="2" >Freq MC</th>
					<th colspan="2" >EL w/o Supporting Doc</th>
					<th colspan="2" >Absent / Absent w/ Reject Or Cancelled</th>
					<th colspan="2" >EL (Below Than 3 Days)</th>
					<th>Total Merit</th>
				</tr>
			</thead>
			<tbody>
@foreach($st as $sf)
<?php $u = $sf->belongtomanyposition()->wherePivot('main', 1)->first() ?>
@if($u->category_id == 1)
<?php
////////////////////////////////////////////////////////////////////////////
// lateness
foreach( $sf->hasmanystafftcms()->whereBetween('date', [$dn->copy()->startOfYear()->format('Y-m-d'), $n->copy()->format('Y-m-d')])->get() as $tc ) {

}

////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////

?>
				<tr>
					<td>{!! $i1++ !!}</td>
					<td>{!! $sf->hasmanylogin()->where('active', 1)->first()->username !!}</td>
					<td>{!! $sf->name !!}</td>
					<td>{!! $sf->belongtolocation->location !!}</td>
					<td>{!! $sf->belongtomanyposition()->wherePivot('main', 1)->first()->belongtodepartment->department !!}</td>
					<td>{!! $i1late !!}</td>
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
					<td></td>
					<td></td>
				</tr>
@endif
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
@foreach($st as $sf)
<?php $u = $sf->belongtomanyposition()->wherePivot('main', 1)->first() ?>
@if($u->category_id == 2)
<?php
////////////////////////////////////////////////////////////////////////////
// lateness
foreach( $sf->hasmanystafftcms()->whereBetween('date', [$dn->copy()->startOfYear()->format('Y-m-d'), $n->copy()->format('Y-m-d')])->get() as $tc ) {

}


////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////

?>
				<tr>
					<td>{!! $i2++ !!}</td>
					<td>{!! $sf->hasmanylogin()->where('active', 1)->first()->username !!}</td>
					<td>{!! $sf->name !!}</td>
					<td>{!! $sf->belongtolocation->location !!}</td>
					<td>{!! $sf->belongtomanyposition()->wherePivot('main', 1)->first()->belongtodepartment->department !!}</td>
					<td>{!! $i2late !!}</td>
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
					<td></td>
					<td></td>
				</tr>
@endif
@endforeach
			</tbody>
		</table>

	</div>
</div>