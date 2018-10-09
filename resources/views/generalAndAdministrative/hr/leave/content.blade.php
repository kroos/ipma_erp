@php
ini_set('max_execution_time', 180);
use \App\Model\Staff;
use \App\Model\StaffLeave;
use Carbon\Carbon;

$bor = Carbon::now();
$bor1 = Carbon::create($bor->year, $bor->month, $bor->day, 0, 0, 0);
$bmonth = $bor->month;
// echo $bmonth.' month now <br />';
// echo $bor1.' now <br />';
// echo $bor1->copy()->subMonth()->startOfMonth().' from start of last month<br />';

if ( $bmonth != 1 ) {
	$sl = StaffLeave::where('active', 1)->whereDate('created_at', '>=', $bor1->copy()->startOfYear())->whereDate('date_time_start', '>', $bor1)->orderBy('date_time_start', 'desc')->get();
	$sla = StaffLeave::where('active', 1)->whereDate('created_at', '>=', $bor1->copy()->startOfYear())->whereDate('date_time_end', '<', $bor1)->orderBy('date_time_end', 'desc')->orderBy('date_time_start', 'DESC')->get();
	$slb = StaffLeave::where('active', 1)->whereDate('created_at', '>=', $bor1->copy()->startOfYear())->whereRaw('"'.$bor1.'" BETWEEN DATE(date_time_start) AND DATE(date_time_end)')->orderBy('date_time_end', 'desc')->get();
	$sl1 = StaffLeave::where('active', 2)->whereDate('created_at', '>=', $bor1->copy()->startOfYear())->whereDate('date_time_start', '>', $bor1)->orderBy('date_time_start', 'desc')->get();
	$sl2 = StaffLeave::where('active', 3)->whereDate('created_at', '>=', $bor1->copy()->startOfYear())->whereDate('date_time_start', '>', $bor1)->orderBy('date_time_start', 'desc')->get();
	$sl3 = StaffLeave::where('active', 4)->whereDate('created_at', '>=', $bor1->copy()->startOfYear())->whereDate('date_time_start', '>', $bor1)->orderBy('date_time_start', 'desc')->get();
} else {
	// if its in january, check the create date from early last month : 1 December, so can capture the leaves.
	$sl = StaffLeave::where('active', 1)->whereDate('created_at', '>=', $bor1->copy()->subMonth()->startOfMonth() )->whereDate('date_time_start', '>', $bor1)->orderBy('date_time_start', 'desc')->get();
	$sla = StaffLeave::where('active', 1)->whereDate('created_at', '>=', $bor1->copy()->subMonth()->startOfMonth() )->whereDate('date_time_end', '<', $bor1)->orderBy('date_time_end', 'desc')->orderBy('date_time_start', 'DESC')->get();
	$slb = StaffLeave::where('active', 1)->whereDate('created_at', '>=', $bor1->copy()->subMonth()->startOfMonth() )->whereRaw('"'.$bor1.'" BETWEEN DATE(date_time_start) AND DATE(date_time_end)')->orderBy('date_time_end', 'desc')->get();
	$sl1 = StaffLeave::where('active', 2)->whereDate('created_at', '>=', $bor1->copy()->subMonth()->startOfMonth() )->whereDate('date_time_start', '>', $bor1)->orderBy('date_time_start', 'desc')->get();
	$sl2 = StaffLeave::where('active', 3)->whereDate('created_at', '>=', $bor1->copy()->subMonth()->startOfMonth() )->whereDate('date_time_start', '>', $bor1)->orderBy('date_time_start', 'desc')->get();
	$sl3 = StaffLeave::where('active', 4)->whereDate('created_at', '>=', $bor1->copy()->subMonth()->startOfMonth() )->whereDate('date_time_start', '>', $bor1)->orderBy('date_time_start', 'desc')->get();
}


@endphp
<ul class="nav nav-pills">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('leaveSetting.index') }}">Settings</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('leaveNRL.index') }}">Non Replacement Leave</a>
	</li>
	<li class="nav-item">
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
	</li>
</ul>
<!-- start table -->
<div class="card">
	<div class="card-header">Active Leaves Record</div>
	<div class="card-body table-responsive">
		@include('layouts.info')
		@include('layouts.errorform')
		<h2 class="card-title">Leaves Detail</h2>

		<table class="table table-hover table-sm" id="leaves" style="font-size:12px">
			<thead>
				<tr class="text-center">
					<th colspan="13"><h3>Incoming Leaves</h3></th>
				</tr>
				<tr>
					<th rowspan="2">ID</th>
					<th rowspan="2">Name</th>
					<th rowspan="2">Date Apply</th>
					<th rowspan="2">Leave</th>
					<th rowspan="2">Reason</th>
					<th colspan="2">Date/Time Leave</th>
					<th rowspan="2">Period</th>
					<th colspan="2">Backup Person</th>
					<th rowspan="2">Approval, Remarks and Updated At</th>
					<th rowspan="2">Remarks</th>
					<th rowspan="2">Leave Status</th>
				</tr>
				<tr>
					<th>From</th>
					<th>To</th>
					<th>Name</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
@foreach($sl as $stl)
<?php
$dts = \Carbon\Carbon::parse($stl->created_at)->format('Y');
$arr = str_split( $dts, 2 );

// determining backup
$usergroup = $stl->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
$userneedbackup = $stl->belongtostaff->leave_need_backup;

if ( ($stl->leave_id == 9) || ($stl->leave_id != 9 && $stl->half_day == 2) ) {
	$dts = \Carbon\Carbon::parse($stl->date_time_start)->format('D, j M Y g:i a');
	$dte = \Carbon\Carbon::parse($stl->date_time_end)->format('D, j M Y g:i a');
	if( ($stl->leave_id != 9 && $stl->half_day == 2 && $stl->active == 1) ) {
		if ($stl->leave_id != 9 && $stl->half_day == 2 && $stl->active != 1) {
			$dper = '0 Day';
		} else {
			$dper = 'Half Day';
		}
	} else {
		$i = $stl->period;
				$hour = floor($i/60);
				$minute = ($i % 60);
		$dper = $hour.' hours '.$minute.' minutes';
	}
} else {
	$dts = \Carbon\Carbon::parse($stl->date_time_start)->format('D, j M Y ');
	$dte = \Carbon\Carbon::parse($stl->date_time_end)->format('D, j M Y ');
	$dper = $stl->period.' day/s';
}

if( !empty($stl->hasonestaffleavebackup) ) {
	$officer = $stl->hasonestaffleavebackup->belongtostaff->name;
	if( $stl->hasonestaffleavebackup->acknowledge === NULL ) {
		$stat = 'Pending';
	}
	if($stl->hasonestaffleavebackup->acknowledge === 1) {
		$stat = 'Approve';
	}
	if($stl->hasonestaffleavebackup->acknowledge === 0) {
		$stat = 'Reject';
	}
} else {
	$officer = 'No Backup';
	$stat = 'No Backup';
}
?>
@if($stl->belongtostaff->active == 1 )
				<tr>
					<td>
@if($stl->leave_id != 7)
						<a href="{{ route('staffLeaveHR.edit', $stl->id) }}">HR9-{{ str_pad( $stl->leave_no, 5, "0", STR_PAD_LEFT ) }}/{{ $arr[1] }}</a>
@else
						HR9-{{ str_pad( $stl->leave_no, 5, "0", STR_PAD_LEFT ) }}/{{ $arr[1] }}
@endif
						<br />
					</td>
					<td>{{ $stl->belongtostaff->name }}</td>
					<td>{{ Carbon::parse($stl->created_at)->format('D, j M y') }}</td>
					<td>{{ $stl->belongtoleave->leave }}</td>
					<td>{{ ucwords(strtolower(trim($stl->reason))) }}</td>
					<td>{{ $dts }}</td>
					<td>{{ $dte }}</td>
					<td>{{ $dper }}</td>
					<td>{{ $officer }}</td>
					<td>{{ $stat }}</td>
					<td>
						<table class="table table-hover">
							<tbody>
@foreach( $stl->hasmanystaffapproval()->get() as $appr )
								<tr>
									<td>{{ $appr->belongtostaff->name }}</td>
									<td>{{ ( !isset($appr->approval) )?'Pending':(($appr->approval === 1)?'Approve':'Reject') }}</td>
									<td>{{ $appr->notes_by_approval }}</td>
									<td>{{ \Carbon\Carbon::parse($appr->updated_at)->format('D, j M Y g:i A') }}</td>
								</tr>
@endforeach
							</tbody>
						</table>
					</td>
					<td>{{ $stl->remarks }}</td>
					<td>{{ $stl->belongtoleavestatus->status }}</td>
				</tr>
@endif
@endforeach
			</tbody>
		</table>
	<br />
	<hr />
		<table class="table table-hover table-sm" id="leaves1" style="font-size:12px">
			<thead>
				<tr class="text-center">
					<th colspan="13"><h3>Today Leaves</h3></th>
				</tr>
				<tr>
					<th rowspan="2">ID</th>
					<th rowspan="2">Name</th>
					<th rowspan="2">Date Apply</th>
					<th rowspan="2">Leave</th>
					<th rowspan="2">Reason</th>
					<th colspan="2">Date/Time Leave</th>
					<th rowspan="2">Period</th>
					<th colspan="2">Backup Person</th>
					<th rowspan="2">Approval, Remarks and Updated At</th>
					<th rowspan="2">Remarks</th>
					<th rowspan="2">Leave Status</th>
				</tr>
				<tr>
					<th>From</th>
					<th>To</th>
					<th>Name</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
@foreach($slb as $stl1)
<?php
$dts = \Carbon\Carbon::parse($stl1->created_at)->format('Y');
$arr = str_split( $dts, 2 );

// determining backup
$usergroup = $stl1->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
$userneedbackup = $stl1->belongtostaff->leave_need_backup;

if ( ($stl1->leave_id == 9) || ($stl1->leave_id != 9 && $stl1->half_day == 2) ) {
	$dts = \Carbon\Carbon::parse($stl1->date_time_start)->format('D, j M Y g:i a');
	$dte = \Carbon\Carbon::parse($stl1->date_time_end)->format('D, j M Y g:i a');
	if( ($stl1->leave_id != 9 && $stl1->half_day == 2 && $stl1->active == 1) ) {
		if ($stl1->leave_id != 9 && $stl1->half_day == 2 && $stl1->active != 1) {
			$dper = '0 Day';
		} else {
			$dper = 'Half Day';
		}
	} else {
		$i = $stl1->period;
				$hour = floor($i/60);
				$minute = ($i % 60);
		$dper = $hour.' hours '.$minute.' minutes';
	}
} else {
	$dts = \Carbon\Carbon::parse($stl1->date_time_start)->format('D, j M Y ');
	$dte = \Carbon\Carbon::parse($stl1->date_time_end)->format('D, j M Y ');
	$dper = $stl1->period.' day/s';
}

if( !empty($stl1->hasonestaffleavebackup) ) {
	$officer = $stl1->hasonestaffleavebackup->belongtostaff->name;
	if( $stl1->hasonestaffleavebackup->acknowledge === NULL ) {
		$stat = 'Pending';
	}
	if($stl1->hasonestaffleavebackup->acknowledge === 1) {
		$stat = 'Approve';
	}
	if($stl1->hasonestaffleavebackup->acknowledge === 0) {
		$stat = 'Reject';
	}
} else {
	$officer = 'No Backup';
	$stat = 'No Backup';
}
?>
@if($stl1->belongtostaff->active == 1 )
				<tr>
					<td>
						<a href="{{ route('staffLeaveHR.edit', $stl1->id) }}">HR9-{{ str_pad( $stl1->leave_no, 5, "0", STR_PAD_LEFT ) }}/{{ $arr[1] }}</a>
							<br />
					</td>
					<td>{{ $stl1->belongtostaff->name }}</td>
					<td>{{ Carbon::parse($stl1->created_at)->format('D, j M y') }}</td>
					<td>{{ $stl1->belongtoleave->leave }}</td>
					<td>{{ ucwords(strtolower(trim($stl1->reason))) }}</td>
					<td>{{ $dts }}</td>
					<td>{{ $dte }}</td>
					<td>{{ $dper }}</td>
					<td>{{ $officer }}</td>
					<td>{{ $stat }}</td>
					<td>
						<table class="table table-hover">
							<tbody>
@foreach( $stl1->hasmanystaffapproval()->get() as $appr )
								<tr>
									<td>{{ $appr->belongtostaff->name }}</td>
									<td>{{ ( !isset($appr->approval) )?'Pending':(($appr->approval === 1)?'Approve':'Reject') }}</td>
									<td>{{ $appr->notes_by_approval }}</td>
									<td>{{ \Carbon\Carbon::parse($appr->updated_at)->format('D, j M Y g:i A') }}</td>
								</tr>
@endforeach
							</tbody>
						</table>
					</td>
					<td>{{ $stl1->remarks }}</td>
					<td>{{ $stl1->belongtoleavestatus->status }}</td>
				</tr>
@endif
@endforeach
			</tbody>
		</table>
	<br />


{!! Form::open(['route' => ['staffLeaveHR.updateRHC'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true,  'data-toggle' => 'validator']) !!}
		<table class="table table-hover table-sm" id="leaves2" style="font-size:12px">
			<thead>
				<tr class="text-center">
					<th colspan="14"><h3>Past Leaves</h3></th>
				</tr>
				<tr>
					<th rowspan="2"><input type="checkbox" id="selectAll"><label for="selectAll">Received Hardcopy</label></th>
					<th rowspan="2">ID</th>
					<th rowspan="2">Name</th>
					<th rowspan="2">Date Apply</th>
					<th rowspan="2">Leave</th>
					<th rowspan="2">Reason</th>
					<th colspan="2">Date/Time Leave</th>
					<th rowspan="2">Period</th>
					<th colspan="2">Backup Person</th>
					<th rowspan="2">Approval, Remarks and Updated At</th>
					<th rowspan="2">Remarks</th>
					<th rowspan="2">Leave Status</th>
				</tr>
				<tr>
					<th>From</th>
					<th>To</th>
					<th>Name</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
@foreach($sla as $stl11)
<?php
$nn = Carbon::now()->subDays(2);	// 2 hari selepas bercuti
$nn1 = Carbon::create($nn->year, $nn->month, $nn->day,0 ,0 ,0);
$j = Carbon::parse($stl11->date_time_end);
$j1 = Carbon::create($j->year, $j->month, $j->day,0 ,0 ,0);

$dts = \Carbon\Carbon::parse($stl11->created_at)->format('Y');
$arr = str_split( $dts, 2 );

// determining backup
$usergroup = $stl11->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
$userneedbackup = $stl11->belongtostaff->leave_need_backup;

if ( ($stl11->leave_id == 9) || ($stl11->leave_id != 9 && $stl11->half_day == 2) ) {
	$dts = \Carbon\Carbon::parse($stl11->date_time_start)->format('D, j M Y g:i a');
	$dte = \Carbon\Carbon::parse($stl11->date_time_end)->format('D, j M Y g:i a');
	if( ($stl11->leave_id != 9 && $stl11->half_day == 2 && $stl11->active == 1) ) {
		if ($stl11->leave_id != 9 && $stl11->half_day == 2 && $stl11->active != 1) {
			$dper = '0 Day';
		} else {
			$dper = 'Half Day';
		}
	} else {
		$i = $stl11->period;
				$hour = floor($i/60);
				$minute = ($i % 60);
		$dper = $hour.' hours '.$minute.' minutes';
	}
} else {
	$dts = \Carbon\Carbon::parse($stl11->date_time_start)->format('D, j M Y ');
	$dte = \Carbon\Carbon::parse($stl11->date_time_end)->format('D, j M Y ');
	$dper = $stl11->period.' day/s';
}

if( !empty($stl11->hasonestaffleavebackup) ) {
	$officer = $stl11->hasonestaffleavebackup->belongtostaff->name;
	if( $stl11->hasonestaffleavebackup->acknowledge === NULL ) {
		$stat = 'Pending';
	}
	if($stl11->hasonestaffleavebackup->acknowledge === 1) {
		$stat = 'Approve';
	}
	if($stl11->hasonestaffleavebackup->acknowledge === 0) {
		$stat = 'Reject';
	}
} else {
	$officer = 'No Backup';
	$stat = 'No Backup';
}
?>
@if($stl11->belongtostaff->active == 1 )
				<tr>
					<td>
@if($nn1->gte($j1))
@if( is_null($stl11->document) && is_null($stl11->hardcopy) && ( $stl11->leave_id == 2 || $stl11->leave_id == 5 || $stl11->leave_id == 6 || $stl11->leave_id == 9 || $stl11->leave_id == 11 || $stl11->leave_id == 3 ) )
					<label for="cb{{ $stl11->id }}"><input type="checkbox" value="{{ $stl11->id }}"  name="hardcopy[]" id="cb{{ $stl11->id }}" class="checkbox1"></label>
@endif
@endif
					</td>
					<td>
						<a href="{{ route('staffLeaveHR.edit', $stl11->id) }}">HR9-{{ str_pad( $stl11->leave_no, 5, "0", STR_PAD_LEFT ) }}/{{ $arr[1] }}</a>
							<br />
					</td>
					<td>{{ $stl11->belongtostaff->name }}</td>
					<td>{{ Carbon::parse($stl11->created_at)->format('D, j M y') }}</td>
					<td>{{ $stl11->belongtoleave->leave }}</td>
					<td>{{ ucwords(strtolower(trim($stl11->reason))) }}</td>
					<td>{{ $dts }}</td>
					<td>{{ $dte }}</td>
					<td>{{ $dper }}</td>
					<td>{{ $officer }}</td>
					<td>{{ $stat }}</td>
					<td>
						<table class="table table-hover">
							<tbody>
@foreach( $stl11->hasmanystaffapproval()->get() as $appr )
								<tr>
									<td>{{ $appr->belongtostaff->name }}</td>
									<td>{{ ( !isset($appr->approval) )?'Pending':(($appr->approval === 1)?'Approve':'Reject') }}</td>
									<td>{{ $appr->notes_by_approval }}</td>
									<td>{{ \Carbon\Carbon::parse($appr->updated_at)->format('D, j M Y g:i A') }}</td>
								</tr>
@endforeach
							</tbody>
						</table>
					</td>
					<td>{{ $stl11->remarks }}</td>
					<td>{{ $stl11->belongtoleavestatus->status }}</td>
				</tr>
@endif
@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="14">{!! Form::button('Received Hardcopy', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}</th>
				</tr>
			</tfoot>
		</table>
{!! Form::close() !!}




	<br />
		<table class="table table-hover table-sm" id="leaves3" style="font-size:12px">
			<thead>
				<tr class="text-center">
					<th colspan="13"><h3>Closed Leaves</h3></th>
				</tr>
				<tr>
					<th rowspan="2">ID</th>
					<th rowspan="2">Name</th>
					<th rowspan="2">Date Apply</th>
					<th rowspan="2">Leave</th>
					<th rowspan="2">Reason</th>
					<th colspan="2">Date/Time Leave</th>
					<th rowspan="2">Period</th>
					<th colspan="2">Backup Person</th>
					<th rowspan="2">Approval, Remarks and Updated At</th>
					<th rowspan="2">Remarks</th>
					<th rowspan="2">Leave Status</th>
				</tr>
				<tr>
					<th>From</th>
					<th>To</th>
					<th>Name</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
@foreach($sl1 as $stl0)
<?php
$dts = \Carbon\Carbon::parse($stl0->created_at)->format('Y');
$arr = str_split( $dts, 2 );

// determining backup
$usergroup = $stl0->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
$userneedbackup = $stl0->belongtostaff->leave_need_backup;

if ( ($stl0->leave_id == 9) || ($stl0->leave_id != 9 && $stl0->half_day == 2) ) {
	$dts = \Carbon\Carbon::parse($stl0->date_time_start)->format('D, j M Y g:i a');
	$dte = \Carbon\Carbon::parse($stl0->date_time_end)->format('D, j M Y g:i a');
	if( ($stl0->leave_id != 9 && $stl0->half_day == 2 && $stl0->active == 1) ) {
		if ($stl0->leave_id != 9 && $stl0->half_day == 2 && $stl0->active != 1) {
			$dper = '0 Day';
		} else {
			$dper = 'Half Day';
		}
	} else {
		$i = $stl0->period;
				$hour = floor($i/60);
				$minute = ($i % 60);
		$dper = $hour.' hours '.$minute.' minutes';
	}
} else {
	$dts = \Carbon\Carbon::parse($stl0->date_time_start)->format('D, j M Y ');
	$dte = \Carbon\Carbon::parse($stl0->date_time_end)->format('D, j M Y ');
	$dper = $stl0->period.' day/s';
}

if( !empty($stl0->hasonestaffleavebackup) ) {
	$officer = $stl0->hasonestaffleavebackup->belongtostaff->name;
	if( $stl0->hasonestaffleavebackup->acknowledge === NULL ) {
		$stat = 'Pending';
	}
	if($stl0->hasonestaffleavebackup->acknowledge === 1) {
		$stat = 'Approve';
	}
	if($stl0->hasonestaffleavebackup->acknowledge === 0) {
		$stat = 'Reject';
	}
} else {
	$officer = 'No Backup';
	$stat = 'No Backup';
}
?>
@if($stl0->belongtostaff->active == 1 )
				<tr>
					<td>
						HR9-{{ str_pad( $stl0->leave_no, 5, "0", STR_PAD_LEFT ) }}/{{ $arr[1] }}
							<br />
					</td>
					<td>{{ $stl0->belongtostaff->name }}</td>
					<td>{{ Carbon::parse($stl0->created_at)->format('D, j M y') }}</td>
					<td>{{ $stl0->belongtoleave->leave }}</td>
					<td>{{ ucwords(strtolower(trim($stl0->reason))) }}</td>
					<td>{{ $dts }}</td>
					<td>{{ $dte }}</td>
					<td>{{ $dper }}</td>
					<td>{{ $officer }}</td>
					<td>{{ $stat }}</td>
					<td>
						<table class="table table-hover">
							<tbody>
@foreach( $stl0->hasmanystaffapproval()->get() as $appr )
								<tr>
									<td>{{ $appr->belongtostaff->name }}</td>
									<td>{{ ( !isset($appr->approval) )?'Pending':(($appr->approval === 1)?'Approve':'Reject') }}</td>
									<td>{{ $appr->notes_by_approval }}</td>
									<td>{{ \Carbon\Carbon::parse($appr->updated_at)->format('D, j M Y g:i A') }}</td>
								</tr>
@endforeach
							</tbody>
						</table>
					</td>
					<td>{{ $stl0->remarks }}</td>
					<td>{{ $stl0->belongtoleavestatus->status }}</td>
				</tr>
@endif
@endforeach
			</tbody>
		</table>
	<br />
		<table class="table table-hover table-sm" id="leaves4" style="font-size:12px">
			<thead>
				<tr class="text-center">
					<th colspan="13"><h3>Cancelled Leaves</h3></th>
				</tr>
				<tr>
					<th rowspan="2">ID</th>
					<th rowspan="2">Name</th>
					<th rowspan="2">Date Apply</th>
					<th rowspan="2">Leave</th>
					<th rowspan="2">Reason</th>
					<th colspan="2">Date/Time Leave</th>
					<th rowspan="2">Period</th>
					<th colspan="2">Backup Person</th>
					<th rowspan="2">Approval, Remarks and Updated At</th>
					<th rowspan="2">Remarks</th>
					<th rowspan="2">Leave Status</th>
				</tr>
				<tr>
					<th>From</th>
					<th>To</th>
					<th>Name</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
@foreach($sl2 as $stl2)
<?php
$dts = \Carbon\Carbon::parse($stl2->created_at)->format('Y');
$arr = str_split( $dts, 2 );

// determining backup
$usergroup = $stl2->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
$userneedbackup = $stl2->belongtostaff->leave_need_backup;

if ( ($stl2->leave_id == 9) || ($stl2->leave_id != 9 && $stl2->half_day == 2) ) {
	$dts = \Carbon\Carbon::parse($stl2->date_time_start)->format('D, j M Y g:i a');
	$dte = \Carbon\Carbon::parse($stl2->date_time_end)->format('D, j M Y g:i a');
	if( ($stl2->leave_id != 9 && $stl2->half_day == 2 && $stl2->active == 1) ) {
		if ($stl2->leave_id != 9 && $stl2->half_day == 2 && $stl2->active != 1) {
			$dper = '0 Day';
		} else {
			$dper = 'Half Day';
		}
	} else {
		$i = $stl2->period;
				$hour = floor($i/60);
				$minute = ($i % 60);
		$dper = $hour.' hours '.$minute.' minutes';
	}
} else {
	$dts = \Carbon\Carbon::parse($stl2->date_time_start)->format('D, j M Y ');
	$dte = \Carbon\Carbon::parse($stl2->date_time_end)->format('D, j M Y ');
	$dper = $stl2->period.' day/s';
}

if( !empty($stl2->hasonestaffleavebackup) ) {
	$officer = $stl2->hasonestaffleavebackup->belongtostaff->name;
	if( $stl2->hasonestaffleavebackup->acknowledge === NULL ) {
		$stat = 'Pending';
	}
	if($stl2->hasonestaffleavebackup->acknowledge === 1) {
		$stat = 'Approve';
	}
	if($stl2->hasonestaffleavebackup->acknowledge === 0) {
		$stat = 'Reject';
	}
} else {
	$officer = 'No Backup';
	$stat = 'No Backup';
}
?>
@if($stl2->belongtostaff->active == 1 )
				<tr>
					<td>
						HR9-{{ str_pad( $stl2->leave_no, 5, "0", STR_PAD_LEFT ) }}/{{ $arr[1] }}
							<br />
					</td>
					<td>{{ $stl2->belongtostaff->name }}</td>
					<td>{{ Carbon::parse($stl2->created_at)->format('D, j M y') }}</td>
					<td>{{ $stl2->belongtoleave->leave }}</td>
					<td>{{ ucwords(strtolower(trim($stl2->reason))) }}</td>
					<td>{{ $dts }}</td>
					<td>{{ $dte }}</td>
					<td>{{ $dper }}</td>
					<td>{{ $officer }}</td>
					<td>{{ $stat }}</td>
					<td>
						<table class="table table-hover">
							<tbody>
@foreach( $stl2->hasmanystaffapproval()->get() as $appr )
								<tr>
									<td>{{ $appr->belongtostaff->name }}</td>
									<td>{{ ( !isset($appr->approval) )?'Pending':(($appr->approval === 1)?'Approve':'Reject') }}</td>
									<td>{{ $appr->notes_by_approval }}</td>
									<td>{{ \Carbon\Carbon::parse($appr->updated_at)->format('D, j M Y g:i A') }}</td>
								</tr>
@endforeach
							</tbody>
						</table>
					</td>
					<td>{{ $stl2->remarks }}</td>
					<td>{{ $stl2->belongtoleavestatus->status }}</td>
				</tr>
@endif
@endforeach
			</tbody>
		</table>
	<br />
		<table class="table table-hover table-sm" id="leaves5" style="font-size:12px">
			<thead>
				<tr class="text-center">
					<th colspan="13"><h3>Rejected Leaves</h3></th>
				</tr>
				<tr>
					<th rowspan="2">ID</th>
					<th rowspan="2">Name</th>
					<th rowspan="2">Date Apply</th>
					<th rowspan="2">Leave</th>
					<th rowspan="2">Reason</th>
					<th colspan="2">Date/Time Leave</th>
					<th rowspan="2">Period</th>
					<th colspan="2">Backup Person</th>
					<th rowspan="2">Approval, Remarks and Updated At</th>
					<th rowspan="2">Remarks</th>
					<th rowspan="2">Leave Status</th>
				</tr>
				<tr>
					<th>From</th>
					<th>To</th>
					<th>Name</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
@foreach($sl3 as $stl3)
<?php
$dts = \Carbon\Carbon::parse($stl3->created_at)->format('Y');
$arr = str_split( $dts, 2 );

// determining backup
$usergroup = $stl3->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
$userneedbackup = $stl3->belongtostaff->leave_need_backup;

if ( ($stl3->leave_id == 9) || ($stl3->leave_id != 9 && $stl3->half_day == 2) ) {
	$dts = \Carbon\Carbon::parse($stl3->date_time_start)->format('D, j M Y g:i a');
	$dte = \Carbon\Carbon::parse($stl3->date_time_end)->format('D, j M Y g:i a');
	if( ($stl3->leave_id != 9 && $stl3->half_day == 2 && $stl3->active == 1) ) {
		if ($stl3->leave_id != 9 && $stl3->half_day == 2 && $stl3->active != 1) {
			$dper = '0 Day';
		} else {
			$dper = 'Half Day';
		}
	} else {
		$i = $stl3->period;
				$hour = floor($i/60);
				$minute = ($i % 60);
		$dper = $hour.' hours '.$minute.' minutes';
	}
} else {
	$dts = \Carbon\Carbon::parse($stl3->date_time_start)->format('D, j M Y ');
	$dte = \Carbon\Carbon::parse($stl3->date_time_end)->format('D, j M Y ');
	$dper = $stl3->period.' day/s';
}

if( !empty($stl3->hasonestaffleavebackup) ) {
	$officer = $stl3->hasonestaffleavebackup->belongtostaff->name;
	if( $stl3->hasonestaffleavebackup->acknowledge === NULL ) {
		$stat = 'Pending';
	}
	if($stl3->hasonestaffleavebackup->acknowledge === 1) {
		$stat = 'Approve';
	}
	if($stl3->hasonestaffleavebackup->acknowledge === 0) {
		$stat = 'Reject';
	}
} else {
	$officer = 'No Backup';
	$stat = 'No Backup';
}
?>
@if($stl3->belongtostaff->active == 1 )
				<tr>
					<td>
						HR9-{{ str_pad( $stl3->leave_no, 5, "0", STR_PAD_LEFT ) }}/{{ $arr[1] }}
							<br />
					</td>
					<td>{{ $stl3->belongtostaff->name }}</td>
					<td>{{ Carbon::parse($stl3->created_at)->format('D, j M y') }}</td>
					<td>{{ $stl3->belongtoleave->leave }}</td>
					<td>{{ ucwords(strtolower(trim($stl3->reason))) }}</td>
					<td>{{ $dts }}</td>
					<td>{{ $dte }}</td>
					<td>{{ $dper }}</td>
					<td>{{ $officer }}</td>
					<td>{{ $stat }}</td>
					<td>
						<table class="table table-hover">
							<tbody>
@foreach( $stl3->hasmanystaffapproval()->get() as $appr )
								<tr>
									<td>{{ $appr->belongtostaff->name }}</td>
									<td>{{ ( !isset($appr->approval) )?'Pending':(($appr->approval === 1)?'Approve':'Reject') }}</td>
									<td>{{ $appr->notes_by_approval }}</td>
									<td>{{ \Carbon\Carbon::parse($appr->updated_at)->format('D, j M Y g:i A') }}</td>
								</tr>
@endforeach
							</tbody>
						</table>
					</td>
					<td>{{ $stl3->remarks }}</td>
					<td>{{ $stl3->belongtoleavestatus->status }}</td>
				</tr>
@endif
@endforeach
			</tbody>
		</table>

	</div>
	<div class="card-footer justify-content-center">

	</div>
</div>