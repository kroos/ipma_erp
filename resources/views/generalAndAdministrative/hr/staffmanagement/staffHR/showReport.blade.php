@extends('layouts.app')
<?php
use Carbon\Carbon;


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
												<dd class="col-sm-9">{{ $staffHR->hasmanystaffleave()->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [3, 6])->get()->sum('period') }} days</dd>
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
	$absent = $staffHR->hasmanystafftcms()->where('leave_taken', 'ABSENT')->whereBetween('date', [$dn->copy()->startOfYear()->format('Y-m-d'), $n->copy()->format('Y-m-d')])->get();
	$abs = $absent->count();
	$h = 0;
	foreach ( $absent as $ab ) {
		$c = $staffHR->hasmanystaffleave()->whereRaw('"'.$ab->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->whereNotIn('active', [3, 4]);
		if ( !is_null($c) ) {
			$h += $c->get()->count();
		} else {
			$h += 0;
		}
	}
		// echo $h.' h<br />';
?>
													{{
														($abs) - $h
													}} days
												</dd>
											</dl>


										</div>
									</div>
								</div>
							</div>
						</div>
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

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

