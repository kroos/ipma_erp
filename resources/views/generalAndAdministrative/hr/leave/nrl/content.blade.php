<?php
use \Carbon\Carbon;
use \App\Model\StaffLeaveReplacement;

$now = Carbon::now();

$soy = $now->copy()->startOfYear();
$stmjan = $now->copy()->subMonths(1)->startOfMonth();
$jan = $stmjan->month;

// echo $soy.' soy<br />';
// echo $stmjan.' start of month<br />';
// echo $jan.' month<br />';

// echo StaffLeaveReplacement::where('created_at', '>=', $soy)->where('leave_balance', '>', 0)->orderBy('working_date', 'desc')->get();
// echo StaffLeaveReplacement::where('created_at', '>=', $soy)->where('leave_balance', 0)->orderBy('working_date', 'desc')->get();

if( $jan != 1 ) {
	$tynrl = StaffLeaveReplacement::where('created_at', '>=', $soy)->where('leave_balance', '>', 0)->orderBy('working_date', 'desc')->get();	// not utilized yet
	$tynr2 = StaffLeaveReplacement::where('created_at', '>=', $soy)->where('leave_balance', 0)->orderBy('working_date', 'desc')->get();		// utilized replacement leave
} else {
	$tynrl = StaffLeaveReplacement::where('created_at', '>=', $stmjan)->where('leave_balance', '>', 0)->orderBy('working_date', 'desc')->get();
	$tynr2 = StaffLeaveReplacement::where('created_at', '>=', $stmjan)->where('leave_balance', 0)->orderBy('working_date', 'desc')->get();
}
?>
<ul class="nav nav-pills">
	<li class="nav-item">
		<a class="nav-link " href="{{ route('leaveSetting.index') }}">Settings</a>
	</li>
	<li class="nav-item">
		<a class="nav-link active" href="{{ route('leaveNRL.index') }}">Non Replacement Leave</a>
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

<div class="card">
	<div class="card-header">List of Non Replacement Leave</div>
	<div class="card-body table-responsive">
		@include('layouts.info')
		@include('layouts.errorform')

		<table class="table table-hover table-sm" id="nrl1" style="font-size:12px">
			<thead>
				<tr>
					<th colspan="8"><h3>Unclaimed Replacement Leave</h3></th>
				</tr>
				<tr>
					<th>Staff</th>
					<th>Working Date</th>
					<th>Working Location</th>
					<th>Working Reason</th>
					<th>Remarks</th>
					<th>Total</th>
					<th>Utilize</th>
					<th>Balance</th>
				</tr>
			</thead>
			<tbody>
@foreach( $tynrl as $rnl )
				<tr>
					<td>{!! $rnl->belongtostaff->name !!}</td>
					<td>{!! Carbon::parse($rnl->working_date)->format('D, j M Y') !!}</td>
					<td>{!! $rnl->working_location !!}</td>
					<td>{!! $rnl->working_reason !!}</td>
					<td>{!! $rnl->remarks !!}</td>
					<td>{!! $rnl->leave_total !!}</td>
					<td>{!! $rnl->leave_utilize !!}</td>
					<td>{!! $rnl->leave_balance !!}</td>
				</tr>
@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th>Staff</th>
					<th>Working Date</th>
					<th>Working Location</th>
					<th>Working Reason</th>
					<th>Remarks</th>
					<th>Total</th>
					<th>Utilize</th>
					<th>Balance</th>
				</tr>
			</tfoot>
		</table>
		<p>&nbsp;</p>
		<table class="table table-hover table-sm" id="nrl2" style="font-size:12px">
			<thead>
				<tr>
					<th colspan="8"></th>
				</tr>
				<tr>
					<th>Staff</th>
					<th>Leave ID (HR Ref)</th>
					<th>Date Claimed</th>
					<th>Working Date</th>
					<th>Working Location</th>
					<th>Working Reason</th>
					<th>Remarks</th>
					<th>Total</th>
					<th>Utilize</th>
					<th>Balance</th>
				</tr>
			</thead>
			<tbody>
@foreach($tynr2 as $crl)
<?php
$arr = str_split( Carbon::parse($crl->belongtostaffleave->created_at)->format('Y'), 2 );
?>
				<tr>
					<th>{!! $crl->belongtostaff->name !!}</th>
					<th>HR-{!! str_pad( $crl->belongtostaffleave->leave_no, 5, "0", STR_PAD_LEFT ) !!}/{!! $arr[1] !!}</th>
					<th>{!! Carbon::parse($crl->updated_at)->format('D, j M Y') !!}Date Claimed</th>
					<th>{!! $crl->working_date !!}</th>
					<th>{!! $crl->working_location !!}</th>
					<th>{!! $crl->working_reason !!}</th>
					<th>{!! $crl->remarks !!}</th>
					<th>{!! $crl->leave_total !!} day/s</th>
					<th>{!! $crl->leave_utilize !!} day/s</th>
					<th>{!! $crl->leave_balance !!} day/s</th>
				</tr>
@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th></th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>