@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Leaves Record</h1></div>
	<div class="card-body table-responsive">
		@include('layouts.info')
		@include('layouts.errorform')
		<h2 class="card-title">Leaves Detail</h2>

<?php
// checking AL, MC
$leaveALMC = \Auth::user()->belongtostaff->hasmanystaffannualmcleave()->where('year', date('Y'))->first();
// dd($leaveALMC->first());
?>
		<dl class="row">
			<dt class="col-sm-3"><h5 class="text-danger">Perhatian :</h5></dt>
			<dd class="col-sm-9">
				<p>Sebelum anda boleh mengisi borang permohonan cuti, sila isikan dahulu butiran mengenai anda <a href="{{ route('staff.edit', \Auth::user()->belongtostaff->id ) }}" class="font-weight-bold" >disini</a>.</p>
				<p>Sebaik sahaja anda selesai melengkapkan maklumat mengenai diri anda, anda dibenarkan untuk memohon cuti melaui pautan dibawah <span class="font-weight-bold">"Leave Application"</span></p>
			</dd>

			<dt class="col-sm-3"><h5>Annual Leave :</h5></dt>
			<dd class="col-sm-9">
				<dl class="row">
					<dt class="col-sm-3">Initialize : </dt>
					<dd class="col-sm-9">{{ $leaveALMC->annual_leave + $leaveALMC->annual_leave_adjustment }} days</dd>
					<dt class="col-sm-3">Balance :</dt>
					<dd class="col-sm-9"><span class=" {{ ($leaveALMC->annual_leave_balance < 4)?'text-danger font-weight-bold':'' }}">{{ $leaveALMC->annual_leave_balance }} days</span>
					</dd>
				</dl>
			</dd>

			<dt class="col-sm-3"><h5>MC Leave :</h5></dt>
			<dd class="col-sm-9">
				<dl class="row">
					<dt class="col-sm-3">Initialize :</dt>
					<dd class="col-sm-9">{{ $leaveALMC->medical_leave + $leaveALMC->medical_leave_adjustment }} days</dd>
					<dt class="col-sm-3">Balance :</dt>
					<dd class="col-sm-9"><span class=" {{ ($leaveALMC->medical_leave_balance < 4)?'text-danger font-weight-bold':'' }}">{{ $leaveALMC->medical_leave_balance }} days</span></dd>
				</dl>
			</dd>

@if( \Auth::user()->belongtostaff->gender_id == 2 )
			<dt class="col-sm-3 text-truncate"><h5>Maternity Leave :</h5></dt>
			<dd class="col-sm-9">
				<dl class="row">
					<dt class="col-sm-3">Initialize :</dt>
					<dd class="col-sm-9">{{ $leaveALMC->maternity_leave + $leaveALMC->maternity_leave_adjustment }} days</dd>
					<dt class="col-sm-3">Balance :</dt>
					<dd class="col-sm-9"><span class=" {{ ($leaveALMC->maternity_leave_balance < 4)?'text-danger font-weight-bold':'' }}">{{ $leaveALMC->maternity_leave_balance }} days</span></dd>
				</dl>
			</dd>
@endif
			<dt class="col-sm-3"><h5>Unpaid Leave Utilize :</h5></dt>
			<dd class="col-sm-9">{{ \Auth::user()->belongtostaff->hasmanystaffleave()->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [3, 6])->get()->sum('period') }} days</dd>
<?php
$oi = \Auth::user()->belongtostaff->hasmanystaffleavereplacement()->where('leave_balance', '<>', 0)->get();
?>
@if($oi->sum('leave_balance') > 0)
			<dt class="col-sm-3"><h5>Non Replacement Leave (Cuti Ganti) :</h5></dt>
			<dd class="col-sm-9">{{ $oi->sum('leave_balance') }} days</dd>
@endif
		</dl>

<?php
// dd(\Carbon\Carbon::now()->copy()->startOfYear());
$starty = \Carbon\Carbon::now()->copy()->startOfYear();
$lea = \Auth::user()->belongtostaff->hasmanystaffleave()->where('created_at', '>=', $starty)->get();
// dd($lea);
?>
@if( $lea->count() > 0 )
		<table class="table table-hover table-sm" id="leaves" style="font-size:12px">
			<thead>
				<tr>
					<th rowspan="2">ID</th>
					<th rowspan="2">Date Apply</th>
					<th rowspan="2">Leave</th>
					<th rowspan="2">Reason</th>
					<th colspan="2">Date/Time Leave</th>
					<th rowspan="2">Period</th>
<!-- checking if the user dont need a backup -->
<?php
$usergroup = \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
$userneedbackup = \Auth::user()->belongtostaff->leave_need_backup;
?>
@if( ($usergroup->category_id == 1 || $usergroup->group_id == 5 || $usergroup->group_id == 6) || $userneedbackup == 1 )
					<th colspan="2">Backup Person</th>
@endif
					<th rowspan="2">Approval, Remarks and Updated At</th>
					<th rowspan="2">Remarks</th>
					<th rowspan="2">Leave Status</th>
				</tr>
				<tr>
					<th>From</th>
					<th>To</th>
@if( ($usergroup->category_id == 1 || $usergroup->group_id == 5 || $usergroup->group_id == 6) || $userneedbackup == 1 )
					<th>Name</th>
					<th>Status</th>
@endif
				</tr>
			</thead>
			<tbody>
@foreach($lea as $leav)
				<tr>
					<td>
<?php
$dts = \Carbon\Carbon::parse($leav->date_time_start)->format('Y');
$arr = str_split( $dts, 2 );
// echo $arr[1].'<br />';

if ( ($leav->leave_id == 9) || ($leav->leave_id != 9 && $leav->half_day == 2) ) {
	$dts = \Carbon\Carbon::parse($leav->date_time_start)->format('D, j F Y g:i a');
	$dte = \Carbon\Carbon::parse($leav->date_time_end)->format('D, j F Y g:i a');
	if( ($leav->leave_id != 9 && $leav->half_day == 2 && $leav->active == 1) ) {
		if ($leav->leave_id != 9 && $leav->half_day == 2 && $leav->active != 1) {
			$dper = '0 Day';
		} else {
			$dper = 'Half Day';
		}
	} else {
		$i = $leav->period;
				$hour = floor($i/60);
				$minute = ($i % 60);
		$dper = $hour.' hours '.$minute.' minutes';
	}
} else {
	$dts = \Carbon\Carbon::parse($leav->date_time_start)->format('D, j F Y ');
	$dte = \Carbon\Carbon::parse($leav->date_time_end)->format('D, j F Y ');
	$dper = $leav->period.' day/s';
}

// dd($leav->hasonestaffleavebackup);
// backup value
if( !empty($leav->hasonestaffleavebackup) ) {
	$officer = $leav->hasonestaffleavebackup->belongtostaff->name;
	if( $leav->hasonestaffleavebackup->acknowledge === NULL ) {
		$stat = 'Pending';
	}
	if($leav->hasonestaffleavebackup->acknowledge === 1) {
		$stat = 'Approve';
	}
	if($leav->hasonestaffleavebackup->acknowledge === 0) {
		$stat = 'Reject';
	}
} else {
	$officer = '';
	$stat = '';
}
?>
						HR9-{{ str_pad( $leav->leave_no, 5, "0", STR_PAD_LEFT ) }}/{{ $arr[1] }}
							<br />
						<a href="{{ route( 'printpdfleave.show', $leav->id ) }}" class="btn btn-primary" alt="Print PDF" title="Print PDF" target="_blank"><i class="far fa-file-pdf"></i></a>
<?php
 // only available if only now is before date_time_start and active is 1
$dtsl = \Carbon\Carbon::parse( $leav->date_time_start );
$dt = \Carbon\Carbon::now()->lte( $dtsl );
?>
@if( $leav->active == 1 && $dt == 1 )
						<a href="{{ __('route') }}" class="btn btn-primary cancel_btn" id="cancel_btn_{{ $leav->id }}" data-id="{{ $leav->id }}" alt="Cancel" title="Cancel"><i class="fas fa-ban"></i></a>
@endif
					</td>
					<td>{{ \Carbon\Carbon::parse($leav->created_at)->format('D, j F Y') }}</td>
					<td>{{ $leav->belongtoleave->leave }}</td>
					<td>{{ $leav->reason }}</td>
					<td>{{ $dts }}</td>
					<td>{{ $dte }}</td>
					<td>{{ $dper	}}</td>
@if( ($usergroup->category_id == 1 || $usergroup->group_id == 5 || $usergroup->group_id == 6) || $userneedbackup == 1 )
					<td>{{ $officer }}</td>
					<td>{{ $stat }}</td>
@endif
					<td>
						<table class="table table-hover">
							<tbody>
@foreach( $leav->hasmanystaffapproval()->get() as $appr )
								<tr>
									<td>{{ $appr->belongtostaff->name }}</td>
									<td>{{ ( !isset($appr->approval) )?'Pending':(($appr->approval === 1)?'Approve':'Reject') }}</td>
									<td>{{ $appr->notes_by_approval }}</td>
									<td>{{ \Carbon\Carbon::parse($appr->updated_at)->format('D, j F Y g:i A') }}</td>
								</tr>
@endforeach
							</tbody>
						</table>
					</td>
					<td>{{ $leav->remarks }}</td>
					<td>{{ $leav->belongtoleavestatus->status }}</td>
				</tr>
@endforeach
			</tbody>
		</table>

@else
		<p class="card-text text-justify text-lead">Sorry, no record for your leave. Click on "Leave Application" to apply a leave.</p>
@endif

	</div>
	<div class="card-footer justify-content-center">
<?php
$w = \Auth::user()->belongtostaff->gender_id;
$r = \Auth::user()->belongtostaff->mobile;
?>
		<a href="{{ ( is_null($w) || is_null($r) )?route('staff.edit', \Auth::user()->belongtostaff->id):route('staffLeave.create') }}" class="btn btn-primary">{{ ( is_null($w) || is_null($r) )?'Butiran Diri':'Leave Application' }}</a>
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$("#username").keyup(function() {
	uch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
$.fn.dataTable.moment( 'ddd, D MMMM YYYY' );
$.fn.dataTable.moment( 'ddd, D MMMM YYYY h:mm a' );
$('#leaves').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[0, "desc" ]],	// sorting the 6th column descending
	// responsive: true
});

/////////////////////////////////////////////////////////////////////////////////////////
// cancel leave
$(document).on('click', '.cancel_btn', function(e){
	var ackID = $(this).data('id');
	SwalDelete(ackID);
	e.preventDefault();
});

function SwalDelete(ackID){
	swal({
		title: 'Cancel Leave',
		text: 'Are you sure to cancel this leave?',
		type: 'info',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancel',
		confirmButtonText: 'Yes',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: '{{ url('staffLeave') }}' + '/' + ackID,
					type: 'PATCH',
					dataType: 'json',
					data: {
							id: ackID,
							cancel: 1,
							_token : $('meta[name=csrf-token]').attr('content')
					},
				})
				.done(function(response){
					swal('Accept', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					// $('#cancel_btn_' + ackID).parent().parent().remove();
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
			swal('Cancel Action', 'Leave is still active.', 'info')
		}
	});
}
//auto refresh right after clicking OK button
$(document).on('click', '.swal2-confirm', function(e){
	window.location.reload(true);
});


/////////////////////////////////////////////////////////////////////////////////////////
@endsection

