@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Approval Leave Section</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<dl class="row">
			<dt class="col-sm-3"><h5 class="text-danger">Perhatian :</h5></dt>
			<dd class="col-sm-9">
				<p>nnt pikiaq lain</p>
				<p>:P</p>
			</dd>
		</dl>
<?php
// ada yg kena tambah lagi, contoh utk HOD and HR alert.
$shod = \Auth::user()->belongtostaff->hasmanystaffleaveapproval()->whereNull('hr')->whereNull('approval')->get();

// hr boss
$shr = \Auth::user()->belongtostaff->hasmanystaffleaveapproval()->where('hr', 1)->whereNull('approval')->get();
?>



@if( $shod->count() > 0 )
		<h4>HOD/Supervisor Approval</h4>
		<table class="table table-hover" id="backup">
			<thead>
				<tr>
					<th rowspan="2">ID</th>
					<th rowspan="2">Applicant</th>
					<th rowspan="2">Date Apply</th>
					<th rowspan="2">Leave</th>
					<th rowspan="2">Reason</th>
					<th colspan="2">Date/Time Leave</th>
					<th rowspan="2">Period</th>

					<th colspan="2">Backup Person</th>

					<th rowspan="2">Approval</th>
				</tr>
				<tr>
					<th>From</th>
					<th>To</th>
					<th>Backup</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
@foreach( $shod as $y )
<?php
$arr = str_split( $y->belongtostaffleave->created_at, 2 );

if ( ($y->belongtostaffleave->leave_id == 9) || ($y->belongtostaffleave->leave_id != 9 && $y->belongtostaffleave->half_day == 2) ) {
	$dts = \Carbon\Carbon::parse($y->belongtostaffleave->date_time_start)->format('D, j F Y g:i a');
	$dte = \Carbon\Carbon::parse($y->belongtostaffleave->date_time_end)->format('D, j F Y g:i a');
	if( ($y->belongtostaffleave->leave_id != 9 && $y->belongtostaffleave->half_day == 2) ) {
		$dper = 'Half Day';
	} else {
		$i = $y->belongtostaffleave->period;
				$hour = floor($i/60);
				$minute = ($i % 60);
		$dper = $hour.' hours '.$minute.' minutes';
	}
} else {
	$dts = \Carbon\Carbon::parse($y->belongtostaffleave->date_time_start)->format('D, j F Y ');
	$dte = \Carbon\Carbon::parse($y->belongtostaffleave->date_time_end)->format('D, j F Y ');
	// cant count like this cos it doesnt subtract sunday and public holiday
	// $dper = \Carbon\Carbon::parse($y->belongtostaffleave->date_time_start)->diff(\Carbon\Carbon::parse($y->belongtostaffleave->date_time_end)->addDay())->format('%d day/s');
	$dper = $y->belongtostaffleave->period.' day/s';
}
?>
				<tr>
					<td>HR9-{{ str_pad( $y->belongtostaffleave->leave_no, 5, "0", STR_PAD_LEFT ) }}/{{ $arr[1] }} {{ $y->id }}</td>
					<td>{{ $y->belongtostaffleave->belongtostaff->name }}</td>
					<td>{{ \Carbon\Carbon::parse($y->belongtostaffleave->created_at)->format('D, j F Y') }}</td>
					<td>{{ $y->belongtostaffleave->belongtoleave->leave }}</td>
					<td>{{ $y->belongtostaffleave->reason }}</td>
					<td>{{ $dts }}</td>
					<td>{{ $dte }}</td>
					<td>{{ $dper }}</td>
<?php
if( !empty($y->belongtostaffleave->hasonestaffleavebackup->belongtostaff->name) ) { // backup value
	$officer = $y->belongtostaffleave->hasonestaffleavebackup->belongtostaff->name;
	if( $y->belongtostaffleave->hasonestaffleavebackup->belongtostaff->acknowledge === NULL ) {
		$stat = 'Pending';
	}
	if($y->belongtostaffleave->hasonestaffleavebackup->belongtostaff->acknowledge === 1) {
		$stat = 'Approve';
	}
	if($y->belongtostaffleave->hasonestaffleavebackup->belongtostaff->acknowledge === 0) {
		$stat = 'Reject';
	}
} else {
	$officer = 'No Backup';
	$stat = 'No Backup Status';
}
?>
					<td>{{ $officer }}</td>
					<td>{{ $stat }}</td>
					<td>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter{{ $y->id }}">Approval</button>
					</td>
				</tr>

<!-- modal section for HOD -->
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModalCenter{{ $y->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Approval</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<!-- jom cari jenis cuti -->
<?php
// echo $y->belongtostaffleave->date_time_start.' date time start<br />';
$year = \Carbon\Carbon::parse( $y->belongtostaffleave->date_time_start )->format('Y');
$leave_id = $y->belongtostaffleave->leave_id;
// echo $leave_id.' leave id<br />';

switch ($leave_id) {
	case '1': // al
		$leaveCount = $y->belongtostaffleave->belongtostaff->hasmanystaffannualmcleave()->where('year', $year)->first()->annual_leave_balance;
		$leaveperiod = $y->belongtostaffleave->period;
		$leaverej = $leaveCount + $leaveperiod;
		$text1 = 'Annual Leave (AL) Balance (Accept)';
		$text2 = 'Annual Leave (AL) Balance (Reject)';
		break;

	case '2': // mc
		$leaveCount = $y->belongtostaffleave->belongtostaff->hasmanystaffannualmcleave()->where('year', $year)->first()->medical_leave_balance;
		$leaveperiod = $y->belongtostaffleave->period;
		$leaverej = $leaveCount + $leaveperiod;
		$text1 = 'Medical Leave (MC) Balance (Accept)';
		$text2 = 'Medical Leave (MC) Balance (Reject)';
		break;

	case '3': // upl
		$leaveCount = $y->belongtostaffleave->belongtostaff->hasmanystaffleave()->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [3, 6])->get()->sum('period');
		$leaveperiod = $y->belongtostaffleave->period;
		$leaverej = $leaveCount - $leaveperiod;
		$text1 = 'Unpaid Leave (UPL) Balance (Accept)';
		$text2 = 'Unpaid Leave (UPL) Balance (Reject)';
		break;

	case '4': // nrl
		$leaveCount = $y->belongtostaffleave->belongtostaff->hasmanystaffleavereplacement()->where('leave_balance', '<>', 0)->get()->sum('leave_balance');
		$leaveperiod = $y->belongtostaffleave->period;
		$leaverej = $leaveCount + $leaveperiod;
		$text1 = 'Non Replacement Leave (NRL) Balance  (Cuti Ganti) (Accept)';
		$text2 = 'Non Replacement Leave (NRL) Balance  (Cuti Ganti) (Reject)';
		break;

	case '5': // el-al
		$leaveCount = $y->belongtostaffleave->belongtostaff->hasmanystaffannualmcleave()->where('year', $year)->first()->annual_leave_balance;
		$leaveperiod = $y->belongtostaffleave->period;
		$leaverej = $leaveCount + $leaveperiod;
		$text1 = 'Emergency Annual Leave (EL-AL) Balance (Accept)';
		$text2 = 'Emergency Annual Leave (EL-AL) Balance (Reject)';
		break;

	case '6': // el-upl
		$leaveCount = $y->belongtostaffleave->belongtostaff->hasmanystaffleave()->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [3, 6])->get()->sum('period');
		$leaveperiod = $y->belongtostaffleave->period;
		$leaverej = $leaveCount - $leaveperiod;
		$text1 = 'Emergency Unpaid Leave (EL-UPL) Balance (Accept)';
		$text2 = 'Emergency Unpaid Leave (EL-UPL) Balance (Reject)';
		break;

	case '7': // ml
		$leaveCount = $y->belongtostaffleave->belongtostaff->hasmanystaffannualmcleave()->where('year', $year)->first()->maternity_leave_balance;
		$leaveperiod = $y->belongtostaffleave->period;
		$leaverej = $leaveCount + $leaveperiod;
		$text1 = 'Maternity Leave (ML) Balance (Accept)';
		$text2 = 'Maternity Leave (ML) Balance (Reject)';
		break;

	case '9': // tf
		$hour = floor($y->belongtostaffleave->period/60);
		$minute = ($y->belongtostaffleave->period % 60);
		$dper = $hour.' hours '.$minute.' minutes';

		$dper1 = '0 hours 0 minutes';

		$leaveCount = $dper;
		$leaveperiod = $dper;
		$leaverej = $dper1;
		$text1 = 'Time Off (TF) Balance (Accept)';
		$text2 = 'Time Off (TF) Balance (Reject)';
		break;

	case '11': // mc-upl
		$leaveCount = $y->belongtostaffleave->belongtostaff->hasmanystaffannualmcleave()->where('year', $year)->first()->medical_leave_balance;
		$leaveperiod = $y->belongtostaffleave->period;
		$leaverej = $leaveCount + $leaveperiod;
		$text1 = 'Unpaid Medical Leave (MC-UPL) Balance (Accept)';
		$text2 = 'Unpaid Medical Leave (MC-UPL) Balance (Reject)';
		break;

	default:
	$leaveCount = NULL;
		$text1 = NULL;
		$text2 = NULL;
		break;
}

///////////////////////////////////////////////////////////////////////////
// checking for before or after todays date approval. if its before, have the power to reject and deduct leave, else can approve or reject but not deduct leave.
// date on leave checking

$dts1 = \Carbon\Carbon::parse( $y->belongtostaffleave->date_time_start );
$dte1 = \Carbon\Carbon::parse( $y->belongtostaffleave->date_time_end );
$now = \Carbon\Carbon::now();

?>
@if( $now->lte( $dts1 ) )
				<dl class="row">
					<dt class="col-sm-6">{{ $text1 }}</dt>
					<dd class="col-sm-6">{{ $leaveCount }}</dd>
				</dl>
				<dl class="row">
					<dt class="col-sm-6">{{ $text2 }}</dt>
					<dd class="col-sm-6">{{ $leaverej }}</dd>
				</dl>
@endif
{!! Form::model($y, ['route' => ['staffLeaveApproval.update', $y->id], 'method' => 'PATCH', 'id' => 'form'.$y->id, 'class' => 'form-horizontal', 'autocomplete' => 'off', 'files' => true]) !!}

				<div class="container">
					<div class="row justify-content-sm-center">
						<div class="col-10 text-center">

							<div class="pretty p-default p-curve">
								<input type="radio" name="approval" value="0" required />
								<div class="state p-danger-o">
									<label>Reject</label>
								</div>
							</div>

							<div class="pretty p-default p-curve">
								<input type="radio" name="approval" value="1" required />
								<div class="state p-success-o">
									<label>Accept</label>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputPassword" class="col-sm-2 col-form-label">Remarks</label>
								<div class="col-sm-10">
									<input type="text" name="notes_by_approval" class="form-control remarks" id="inputPassword" placeholder="Remarks">
								</div>
							</div>


						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
{{ Form::close() }}
			</div>
		</div>
	</div>

</div>
<!-- modal for HOD -->

@endforeach
			</tbody>
		</table>
@else
		<p class="card-text text-justify text-lead">No request approval leave.</p>
@endif


























<!-- for hr -->
@if( $shr->count() > 0 )
		<h4>Human Resource Approval</h4>
		<table class="table table-hover" id="backup">
			<thead>
				<tr>
					<th rowspan="2">Applicant</th>
					<th rowspan="2">Date Apply</th>
					<th rowspan="2">Leave</th>
					<th rowspan="2">Reason</th>
					<th colspan="2">Date/Time Leave</th>
					<th rowspan="2">Period</th>
					<th rowspan="2">Approval</th>
				</tr>
				<tr>
					<th>From</th>
					<th>To</th>
				</tr>
			</thead>
			<tbody>
<?php
// $stba = 
?>
@foreach( $shr as $y )
				<tr>
					<td>{{ $y->belongtostaffleave->belongtostaff->name }}</td>
					<td>{{ \Carbon\Carbon::parse($y->belongtostaffleave->created_at)->format('D, j F Y') }}</td>
					<td>{{ $y->belongtostaffleave->belongtoleave->leave }}</td>
					<td>{{ $y->belongtostaffleave->reason }}</td>
@if($y->belongtostaffleave->leave_id == 9)
					<td>{{ \Carbon\Carbon::parse($y->belongtostaffleave->date_time_start)->format('D, j F Y g:i a') }}</td>
					<td>{{ \Carbon\Carbon::parse($y->belongtostaffleave->date_time_end)->format('D, j F Y g:i a') }}</td>
<?php
$hour = floor($y->belongtostaffleave->period/60);
$minute = ($y->belongtostaffleave->period % 60);
$dper = $hour.' hours '.$minute.' minutes';
?>
					<td>{{ $dper }}</td>
@else
					<td>{{ \Carbon\Carbon::parse($y->belongtostaffleave->date_time_start)->format('D, j F Y') }}</td>
					<td>{{ \Carbon\Carbon::parse($y->belongtostaffleave->date_time_end)->format('D, j F Y') }}</td>
<?php
if ($y->belongtostaffleave->period == 0.5) { // period for half day
	$dper = 'Half Day';
} else {
	$dper = $y->belongtostaffleave->period.' day/s';
}
?>
					<td>{{ $dper }}</td>
@endif
					<td> <button class="btn btn-primary ackbtn" id="ackbtn_{{ $y->id }}" data-id="{{ $y->id }}" >Accept</button> </td>
				</tr>
@endforeach
			</tbody>
		</table>
@endif








	</div>
</div>






@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$(".reamrks").keyup(function() {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
//tables
$('#backup').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[0, "desc" ]],	// sorting the 4th column descending
	// responsive: true
});

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

