@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Backup Leave</h1></div>
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
$stba = \Auth::user()->belongtostaff->hasmanystaffleavebackup()->whereNULL('acknowledge')->get();
// dd($stba->count());
?>
@if( $stba->count() > 0 )
		<table class="table table-hover" id="backup" style="font-size:12px">
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
@foreach( $stba as $y )
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
@else
		<p class="card-text text-justify text-lead">No request backup leave.</p>
@endif
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
//tables
$('#backup').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[0, "desc" ]],	// sorting the 4th column descending
	// responsive: true
});

/////////////////////////////////////////////////////////////////////////////////////////
// acknowledge button
$(document).on('click', '.ackbtn', function(e){
	var ackID = $(this).data('id');
	SwalDelete(ackID);
	e.preventDefault();
});

function SwalDelete(ackID){
	swal({
		title: 'Please approve ',
		text: 'Applicants will appreciate it',
		type: 'info',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Reject',
		confirmButtonText: 'Accept',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: '{{ url('staffLeaveBackup') }}' + '/' + ackID,
					type: 'PATCH',
					dataType: 'json',
					data: {
							id: ackID,
							_token : $('meta[name=csrf-token]').attr('content')
					},
				})
				.done(function(response){
					swal('Accept', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					// $('#ackbtn_' + ackID).parent().parent().remove();
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
			swal('Reject', 'Cancel Approval. Ohh.. come on..', 'info')
		}
	});
}
//auto refresh right after clicking OK button
$(document).on('click', '.swal2-confirm', function(e){
	window.location.reload(true);
});



/////////////////////////////////////////////////////////////////////////////////////////
@endsection

