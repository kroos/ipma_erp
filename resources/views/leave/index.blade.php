@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Staff Leaves Record</h1></div>
	<div class="card-body table-responsive">
		@include('layouts.info')
		@include('layouts.errorform')
		<h2 class="card-title">Leaves Detail</h2>

<?php
// dd(\Carbon\Carbon::now()->copy()->startOfYear());
// dd(\Auth::user()->belongtostaff->id);
$lea = \App\Model\StaffLeave::where( 'staff_id', \Auth::user()->belongtostaff->id )->where( 'created_at', '>=', \Carbon\Carbon::now()->copy()->startOfYear() )->get();
// dd($lea);
?>
@if( $lea->count() > 0 )
		<table class="table table-hover" id="leaves">
			<thead>
				<tr>
					<th>id</th>
					<th>Date Apply</th>
					<th>Leave</th>
					<th>Date Leave</th>
					<th>Period</th>
					<th>Backup Person</th>
					<th>Approval & Remarks</th>
				</tr>
			</thead>
			<tbody>
@foreach($lea as $leav)
				<tr>
					<td>{{ $leav->id }}</td>
					<td>{{ \Carbon\Carbon::parse($leav->created_at)->format('Y-m-d H:i') }}</td>
					<td>{{ $leav->leave_id }}</td>
					<td>{{ $leav->reason }}</td>
					<td>{{ $leav->date_time_start.' => '.$leav->date_time_end }}</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th>id</th>
					<th>Date Apply</th>
					<th>Leave</th>
					<th>Date Leave</th>
					<th>Period</th>
					<th>Backup Person</th>
					<th>Approval & Remarks</th>
				</tr>
			</tfoot>
		</table>

@else
		<p class="card-text text-justify text-lead">Sorry, no record for your leave. Click on "Apply Leave" to apply a leave.</p>
@endif

	</div>
	<div class="card-footer">
		<p><a href="{{ route('staffLeave.create') }}" class="btn btn-primary">Apply Leave</a></p>
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
$('#leaves').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[0, "desc" ]],	// sorting the 4th column descending
	// responsive: true
});
@endsection

