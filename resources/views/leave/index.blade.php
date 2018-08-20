@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Staff Leaves Record</h1></div>
	<div class="card-body table-responsive">
		@include('layouts.info')
		@include('layouts.errorform')
		<h2 class="card-title">Leaves Detail</h2>







		<dl class="row">
			<dt class="col-sm-3">Description lists</dt>
			<dd class="col-sm-9">A description list is perfect for defining terms.</dd>

			<dt class="col-sm-3">Euismod</dt>
			<dd class="col-sm-9">
				<p>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.</p>
				<p>Donec id elit non mi porta gravida at eget metus.</p>
			</dd>

			<dt class="col-sm-3">Malesuada porta</dt>
			<dd class="col-sm-9">Etiam porta sem malesuada magna mollis euismod.</dd>

			<dt class="col-sm-3 text-truncate">Truncated term is truncated</dt>
			<dd class="col-sm-9">Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</dd>

			<dt class="col-sm-3">Nesting</dt>
			<dd class="col-sm-9">
				<dl class="row">
					<dt class="col-sm-4">Nested definition list</dt>
					<dd class="col-sm-8">Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc.</dd>
				</dl>
			</dd>
		</dl>








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
					<th rowspan="2">Approval & Remarks</th>
				</tr>
				<tr>
					<th>From</th>
					<th>To</th>
					<th>Name</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
@foreach($lea as $leav)
				<tr>
					<td>
<?php
$arr = str_split( date('Y'), 2 );
// echo $arr[1].'<br />';
?>
						<a href="{{ route('staffLeave.show', $leav->id) }}" alt="Details" title="Details">HR9-{{ str_pad( $leav->leave_no, 5, "0", STR_PAD_LEFT ) }}/{{ $arr[1] }}</a>
							<br />
						<a href="{{ __('route') }}" alt="Print PDF" title="Print PDF"><i class="far fa-file-pdf"></i></a>
							<br />
						<a href="{{ __('route') }}" alt="Cancel" title="Cancel"><i class="fas fa-ban"></i></a>
							<br />
					</td>
					<td>{{ \Carbon\Carbon::parse($leav->created_at)->format('D, j F Y') }}</td>
					<td>{{ $leav->belongtoleave->leave }}</td>
					<td>{{ $leav->reason }}</td>
					<td>
						{{ ($leav->leave_id != 8)?\Carbon\Carbon::parse($leav->date_time_start)->format('D, j F Y '):\Carbon\Carbon::parse($leav->date_time_start)->format('D, j F Y g:i a') }}
					</td>
					<td>
						{{ ($leav->leave_id != 8 )?\Carbon\Carbon::parse($leav->date_time_end)->format('D, j F Y'):\Carbon\Carbon::parse($leav->date_time_end)->format('D, j F Y g:i a') }}
					</td>
					<td>
						{{ ($leav->leave_id != 8 )?\Carbon\Carbon::parse($leav->date_time_start)->diff(\Carbon\Carbon::parse($leav->date_time_end)->addDay())->format('%d day/s'):\Carbon\Carbon::parse($leav->date_time_start)->diff(\Carbon\Carbon::parse($leav->date_time_end))->format('%h hours %i minutes') }}
					</td>
@if( ($usergroup->category_id == 1 || $usergroup->group_id == 5 || $usergroup->group_id == 6) || $userneedbackup == 1 )
					<td>{{ (empty($leav->hasonestaffleavebackup))?'':$leav->hasonestaffleavebackup->belongtostaff->name }}</td>
					<td>{{ (empty($leav->hasonestaffleavebackup))?'':($leav->hasonestaffleavebackup->acknowledge != 0)?'Accept':'Pending' }}</td>
@endif
					<td>
						<table class="table table-hover">
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

