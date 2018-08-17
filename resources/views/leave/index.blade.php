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

function my($string) {
	if (empty($string))	{
		$string = '1900-01-01';		
	}
	$rt = \Carbon\Carbon::createFromFormat('Y-m-d', $string);
	return date('D, d F Y', mktime(0, 0, 0, $rt->month, $rt->day, $rt->year));
}
?>
@if( $lea->count() > 0 )
		<table class="table table-hover" id="leaves">
			<thead>
				<tr>
					<th>id</th>
					<th>Date Apply</th>
					<th>Leave</th>
					<th>Reason</th>
					<th>Date/Time Leave</th>
					<th>Period</th>
<!-- checking if the user dont need a backup -->
<?php
$usergroup = \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
$userneedbackup = \Auth::user()->belongtostaff->leave_need_backup;
// dd( $userneedbackup );
?>
@if( ($usergroup->category_id == 1 || $usergroup->group_id == 5 || $usergroup->group_id == 6) || $userneedbackup == 1 )
					<th>Backup Person</th>
@endif
					<th>Approval & Remarks</th>
				</tr>
			</thead>
			<tbody>
@foreach($lea as $leav)
				<tr>
					<td>HR{{ date('Y-m').'-'.$leav->id }}</td>
					<td>{{ \Carbon\Carbon::parse($leav->created_at)->format('D, j F Y') }}</td>
					<td>{{ $leav->belongtoleave->leave }}</td>
					<td>{{ $leav->reason }}</td>
					<td>
						<table class="table table-hover">
							<tbody>
								<tr><td>From :</td>
									<td>{{ ($leav->leave_id != 8)?\Carbon\Carbon::parse($leav->date_time_start)->format('D, j F Y '):\Carbon\Carbon::parse($leav->date_time_start)->format('D, j F Y g:i a') }}</td>
								</tr>
								<tr>
									<td>To :</td>
									<td>{{ ($leav->leave_id != 8 )?\Carbon\Carbon::parse($leav->date_time_end)->format('D, j F Y'):\Carbon\Carbon::parse($leav->date_time_end)->format('D, j F Y g:i a') }}</td>
								</tr>
							</tbody>
						</table>
					</td>
					<td>
						{{ ($leav->leave_id != 8 )?\Carbon\Carbon::parse($leav->date_time_start)->diff(\Carbon\Carbon::parse($leav->date_time_end)->addDay())->format('%d day/s'):\Carbon\Carbon::parse($leav->date_time_start)->diff(\Carbon\Carbon::parse($leav->date_time_end))->format('%h hours %i minutes') }}
					</td>
@if( ($usergroup->category_id == 1 || $usergroup->group_id == 5 || $usergroup->group_id == 6) || $userneedbackup == 1 )
					<td>
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Name</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{ (empty($leav->hasonestaffleavebackup))?'':$leav->hasonestaffleavebackup->belongtostaff->name }}</td>
									<td>{{ (empty($leav->hasonestaffleavebackup))?'':($leav->hasonestaffleavebackup->acknowledge != 0)?'Accept':'Pending' }}</td>
								</tr>
							</tbody>
						</table>
					</td>
@endif
					<td>
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Name</th>
									<th>Status</th>
									<th>Remarks</th>
								</tr>
							</thead>
							<tbody>
@foreach( $leav->hasmanystaffapproval()->get() as $appr )
								<tr>
									<td>{{ $appr->belongtostaff->name }}</td>
									<td>{{ ( !isset($appr->approval) )?'Pending':(($appr->approval == 1)?'Approve':'Reject') }}</td>
									<td>{{ $appr->notes_by_approval }}</td>
								</tr>
@endforeach
							</tbody>
						</table>
					</td>
				</tr>
@endforeach
			</tbody>
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

