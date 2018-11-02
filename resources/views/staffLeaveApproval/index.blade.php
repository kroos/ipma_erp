@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Approval Leave Section</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

<!-- 		<dl class="row">
			<dt class="col-sm-3"><h5 class="text-danger">Perhatian :</h5></dt>
			<dd class="col-sm-9">
				<p>nnt pikiaq lain</p>
				<p>:P</p>
			</dd>
		</dl> -->
<?php
// ada yg kena tambah lagi, contoh utk HOD and HR alert.
$shod = \Auth::user()->belongtostaff->hasmanystaffleaveapproval()->whereNull('hr')->whereNull('approval')->get();

// hr boss
$shr = \Auth::user()->belongtostaff->hasmanystaffleaveapproval()->where('hr', 1)->whereNull('approval')->get();
?>



@if( $shod->count() > 0 )
		<h4>HOD/Supervisor Approval</h4>
		<table class="table table-hover" id="backup" style="font-size:12px">
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

	// checking for staff leave is active only
	// echo $y->belongtostaffleave->active.' active<br />';

	?>
@if($y->belongtostaffleave->active == 1)
					<tr>
						<td>HR9-{{ str_pad( $y->belongtostaffleave->leave_no, 5, "0", STR_PAD_LEFT ) }}/{{ $arr[1] }}</td>
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
@endif
@endforeach
			</tbody>
		</table>
@endif

















<!-- for hr -->
@if( $shr->count() > 0 )
		<h4>Human Resource Approval</h4>
		<table class="table table-hover" id="backup" style="font-size:12px">
			<thead>
				<tr>
					<th rowspan="2">ID</th>
					<th rowspan="2">Applicant</th>
					<th rowspan="2">Date Apply</th>
					<th rowspan="2">Leave</th>
					<th rowspan="2">Reason</th>
					<th colspan="2">Date/Time Leave</th>
					<th rowspan="2">Period</th>
					<th colspan="3">HOD/Supervisor</th>
					<th rowspan="2">Approval</th>
				</tr>
				<tr>
					<th>From</th>
					<th>To</th>
					<th>HOD</th>
					<th>Approval</th>
					<th>Notes</th>
				</tr>
			</thead>
			<tbody>
@foreach( $shr as $ya )
@if($ya->belongtostaffleave->active == 1)
<?php
	$arrr = str_split( $ya->belongtostaffleave->created_at, 2 );

	if ( ($ya->belongtostaffleave->leave_id == 9) || ($ya->belongtostaffleave->leave_id != 9 && $ya->belongtostaffleave->half_day == 2) ) {
		$dts = \Carbon\Carbon::parse($ya->belongtostaffleave->date_time_start)->format('D, j F Y g:i a');
		$dte = \Carbon\Carbon::parse($ya->belongtostaffleave->date_time_end)->format('D, j F Y g:i a');
		if( ($ya->belongtostaffleave->leave_id != 9 && $ya->belongtostaffleave->half_day == 2) ) {
			$dper = 'Half Day';
		} else {
			$i = $ya->belongtostaffleave->period;
					$hour = floor($i/60);
					$minute = ($i % 60);
			$dper = $hour.' hours '.$minute.' minutes';
		}
	} else {
		$dts = \Carbon\Carbon::parse($ya->belongtostaffleave->date_time_start)->format('D, j F Y ');
		$dte = \Carbon\Carbon::parse($ya->belongtostaffleave->date_time_end)->format('D, j F Y ');
		// cant count like this cos it doesnt subtract sunday and public holiday
		// $dper = \Carbon\Carbon::parse($y->belongtostaffleave->date_time_start)->diff(\Carbon\Carbon::parse($y->belongtostaffleave->date_time_end)->addDay())->format('%d day/s');
		$dper = $ya->belongtostaffleave->period.' day/s';
	}

// echo $ya->belongtostaffleave->hasmanystaffapproval()->whereNull('hr')->first().' staff leave approval model<br />';
$hodsn = $ya->belongtostaffleave->hasmanystaffapproval()->whereNull('hr')->first();
if(is_null($hodsn)) {
	$officer = NULL;
	$appr = NULL;
	$notes = NULL;
} else {
	$officer = $hodsn->belongtostaff->name;
	switch ($hodsn->approval) {
		case '1':
			$appr = 'Approve';
			break;

		case '0':
			$appr = 'Reject';
			break;

		case NULL:
			$appr = 'Pending';
			break;
	}

	$notes = ucwords(strtolower($hodsn->notes_by_approval));
}
?>
					<tr>
						<td>HR9-{{ str_pad( $ya->belongtostaffleave->leave_no, 5, "0", STR_PAD_LEFT ) }}/{{ $arrr[1] }}</td>
						<td>{{ $ya->belongtostaffleave->belongtostaff->name }}</td>
						<td>{{ \Carbon\Carbon::parse($ya->belongtostaffleave->created_at)->format('D, j F Y') }}</td>
						<td>{{ $ya->belongtostaffleave->belongtoleave->leave }}</td>
						<td>{{ $ya->belongtostaffleave->reason }}</td>
						<td>{{ $dts }}</td>
						<td>{{ $dte }}</td>
						<td>{{ $dper }}</td>
						<td>{{ $officer }}</td>
						<td>{{ $appr }}</td>
						<td>{{ $notes }}</td>
						<td>
							<button class="btn btn-primary" data-toggle="modal" data-target="#ModalCenter{{ $ya->id }}" {{ (!is_null($hodsn) && is_null($hodsn->approval))?'disabled="disabled"':NULL }}>Approval</button>
						</td>
					</tr>
	<!-- modal section for HR -->
	<!-- Modal -->
	<div class="modal fade bd-example-modal-lg" id="ModalCenter{{ $ya->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
	// echo $ya->belongtostaffleave->date_time_start.' date time start<br />';
	$year = \Carbon\Carbon::parse( $ya->belongtostaffleave->date_time_start )->format('Y');
	$leave_id = $ya->belongtostaffleave->leave_id;
	// echo $leave_id.' leave id<br />';
	
	switch ($leave_id) {
		case '1': // al
			$leaveCount = $ya->belongtostaffleave->belongtostaff->hasmanystaffannualmcleave()->where('year', $year)->first()->annual_leave_balance;
			$leaveperiod = $ya->belongtostaffleave->period;
			$leaverej = $leaveCount + $leaveperiod;
			$text1 = 'Annual Leave (AL) Balance (Accept)';
			$text2 = 'Annual Leave (AL) Balance (Reject)';
			break;
	
		case '2': // mc
			$leaveCount = $ya->belongtostaffleave->belongtostaff->hasmanystaffannualmcleave()->where('year', $year)->first()->medical_leave_balance;
			$leaveperiod = $ya->belongtostaffleave->period;
			$leaverej = $leaveCount + $leaveperiod;
			$text1 = 'Medical Leave (MC) Balance (Accept)';
			$text2 = 'Medical Leave (MC) Balance (Reject)';
			break;
	
		case '3': // upl
			$leaveCount = $ya->belongtostaffleave->belongtostaff->hasmanystaffleave()->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [3, 6])->get()->sum('period');
			$leaveperiod = $ya->belongtostaffleave->period;
			$leaverej = $leaveCount - $leaveperiod;
			$text1 = 'Unpaid Leave (UPL) Balance (Accept)';
			$text2 = 'Unpaid Leave (UPL) Balance (Reject)';
			break;
	
		case '4': // nrl
			$leaveCount = $ya->belongtostaffleave->belongtostaff->hasmanystaffleavereplacement()->where('leave_balance', '<>', 0)->get()->sum('leave_balance');
			$leaveperiod = $ya->belongtostaffleave->period;
			$leaverej = $leaveCount + $leaveperiod;
			$text1 = 'Non Replacement Leave (NRL) Balance  (Cuti Ganti) (Accept)';
			$text2 = 'Non Replacement Leave (NRL) Balance  (Cuti Ganti) (Reject)';
			break;
	
		case '5': // el-al
			$leaveCount = $ya->belongtostaffleave->belongtostaff->hasmanystaffannualmcleave()->where('year', $year)->first()->annual_leave_balance;
			$leaveperiod = $ya->belongtostaffleave->period;
			$leaverej = $leaveCount + $leaveperiod;
			$text1 = 'Emergency Annual Leave (EL-AL) Balance (Accept)';
			$text2 = 'Emergency Annual Leave (EL-AL) Balance (Reject)';
			break;
	
		case '6': // el-upl
			$leaveCount = $ya->belongtostaffleave->belongtostaff->hasmanystaffleave()->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [3, 6])->get()->sum('period');
			$leaveperiod = $ya->belongtostaffleave->period;
			$leaverej = $leaveCount - $leaveperiod;
			$text1 = 'Emergency Unpaid Leave (EL-UPL) Balance (Accept)';
			$text2 = 'Emergency Unpaid Leave (EL-UPL) Balance (Reject)';
			break;
	
		case '7': // ml
			$leaveCount = $ya->belongtostaffleave->belongtostaff->hasmanystaffannualmcleave()->where('year', $year)->first()->maternity_leave_balance;
			$leaveperiod = $ya->belongtostaffleave->period;
			$leaverej = $leaveCount + $leaveperiod;
			$text1 = 'Maternity Leave (ML) Balance (Accept)';
			$text2 = 'Maternity Leave (ML) Balance (Reject)';
			break;
	
		case '9': // tf
			$hour = floor($ya->belongtostaffleave->period/60);
			$minute = ($ya->belongtostaffleave->period % 60);
			$dper = $hour.' hours '.$minute.' minutes';
	
			$dper1 = '0 hours 0 minutes';
	
			$leaveCount = $dper;
			$leaveperiod = $dper;
			$leaverej = $dper1;
			$text1 = 'Time Off (TF) Balance (Accept)';
			$text2 = 'Time Off (TF) Balance (Reject)';
			break;
	
		case '11': // mc-upl
			$leaveCount = $ya->belongtostaffleave->belongtostaff->hasmanystaffannualmcleave()->where('year', $year)->first()->medical_leave_balance;
			$leaveperiod = $ya->belongtostaffleave->period;
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
	?>
					<dl class="row">
						<dt class="col-sm-6">{{ $text1 }}</dt>
						<dd class="col-sm-6">{{ $leaveCount }}</dd>
					</dl>
					<dl class="row">
						<dt class="col-sm-6">{{ $text2 }}</dt>
						<dd class="col-sm-6">{{ $leaverej }}</dd>
					</dl>
	{!! Form::model($ya, ['route' => ['staffLeaveApproval.update', $ya->id], 'method' => 'PATCH', 'id' => 'form'.$ya->id, 'class' => 'form-horizontal', 'autocomplete' => 'off', 'files' => true]) !!}
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
	<!-- modal for HR -->
@endif
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
	"order": [[5, "desc" ]],	// sorting the 4th column descending
	// responsive: true
});

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

