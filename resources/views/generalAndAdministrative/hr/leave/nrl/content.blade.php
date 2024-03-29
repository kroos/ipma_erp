<?php
use \Carbon\Carbon;
use \App\Model\StaffLeaveReplacement;
use \App\Model\StaffLeave;
use \App\Model\Staff;

$now = Carbon::now();

$soy = $now->copy()->startOfYear();
$stmjan = $now->copy()->subMonths(1)->startOfMonth();
$jan = $stmjan->month;

// echo $soy.' soy<br />';
// echo $stmjan.' start of month<br />';
// echo $jan.' month<br />';

// echo StaffLeaveReplacement::where('created_at', '>=', $soy)->where('leave_balance', '>', 0)->orderBy('working_date', 'desc')->get();
// echo StaffLeaveReplacement::where('created_at', '>=', $soy)->where('leave_balance', 0)->orderBy('working_date', 'desc')->get();

// echo Staff::where('active', 1)->get();

if( $jan != 1 ) {
	$tynrl = StaffLeaveReplacement::where('created_at', '>=', $soy)->where('leave_balance', '>', 0)->orderBy('working_date', 'desc')->get();	// not utilized yet
	$tynr2 = StaffLeave::where('created_at', '>=', $soy)->where('leave_id', 4)->orderBy('date_time_start', 'desc')->get();		// utilized replacement leave
} else {
	$tynrl = StaffLeaveReplacement::where('created_at', '>=', $stmjan)->where('leave_balance', '>', 0)->orderBy('working_date', 'desc')->get();
	$tynr2 = StaffLeave::where('created_at', '>=', $stmjan)->where('leave_id', 4)->orderBy('date_time_start', 'desc')->get();
}
?>
<ul class="nav nav-pills">
	<li class="nav-item">
		<a class="nav-link " href="{{ route('leaveSetting.index') }}">Settings</a>
	</li>
	<li class="nav-item">
		<a class="nav-link active" href="{{ route('leaveNRL.index') }}">Non Record Leave</a>
	</li>
<!-- 	<li class="nav-item">
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
	</li> -->
</ul>

<div class="card">
	<div class="card-header">List of Replacement Leave</div>
	<div class="card-body table-responsive">
		@include('layouts.info')
		@include('layouts.errorform')

		<div class="card">
			<div class="card-header">Unclaimed Non Record Leave</div>
			<div class="card-body">
				<table class="table table-hover table-sm" id="nrl1" style="font-size:12px">
					<thead>
						<tr>
							<th colspan="9"><h3>Unclaimed Non Record Leave</h3></th>
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
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
				@foreach( $tynrl as $rnl )
				@if($rnl->belongtostaff->active == 1)
						<tr>
							<td>{!! $rnl->belongtostaff->hasmanylogin()->where('active', 1)->first()->username !!} {!! $rnl->belongtostaff->name !!}</td>
							<td>{!! Carbon::parse($rnl->working_date)->format('D, j M Y') !!}</td>
							<td>{!! $rnl->working_location !!}</td>
							<td>{!! $rnl->working_reason !!}</td>
							<td>{!! $rnl->remarks !!}</td>
							<td>{!! $rnl->leave_total !!}</td>
							<td>{!! $rnl->leave_utilize !!}</td>
							<td>{!! $rnl->leave_balance !!}</td>
							<td>
								<a href="{{ route('staffLeaveReplacement.edit', $rnl->id) }}" title="Edit" class=""><i class="far fa-edit"></i></a>
								<span title="Delete" class="text-danger delete_nrl" id="delete_nrl_{!! $rnl->id !!}" data-id="{!! $rnl->id !!}"><i class="fas fa-trash" aria-hidden="true"></i></span>
							</td>
						</tr>
				@endif
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
			</div>
			<div class="card-footer"><a href="{{ route('staffLeaveReplacement.create') }}" class="btn btn-primary float-right">Add Replacement Leave</a></div>
		</div>
		<p>&nbsp;</p>
<div class="card">
	<div class="card-header">Claimed Replacement Leave</div>
	<div class="card-body">
		<table class="table table-hover table-sm" id="nrl2" style="font-size:12px">
			<thead>
				<tr>
					<th colspan="10"><h3>Claimed Replacement Leave</h3></th>
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

		@if($crl->belongtostaff->active == 1)

		<?php
		if( is_null( $crl->leave_replacement_id ) ) {
			$href = NULL;
		} else {
			$arr = str_split( Carbon::parse($crl->created_at)->format('Y'), 2 );
			$href = 'HR9-'.str_pad( $crl->leave_no, 5, "0", STR_PAD_LEFT ).'/'.$arr[1];
		}
		?>
				<tr>
					<td>ID {{ $crl->id }} => {!! $crl->belongtostaff->hasmanylogin()->where('active', 1)->first()->username !!} {!! $crl->belongtostaff->name !!} => {!! $crl->created_at !!}</td>
					<td>
		<?php
		$i = 0;
		if(is_null($href)) {
		$p = StaffLeaveReplacement::where('staff_id', $crl->staff_id)->where('leave_balance', 0)->get();
		// echo $p.' query<br />';
		?>
		<select name="xtau" id="sel{!! $i !!}">
			@foreach($p as $t)
			<option value="{{ $t->id }}">ID {{ $t->id }}  => Staff ID {{ $t->staff_id }}  => {{ $t->created_at }} => Remarks {!! $t->remarks !!}</option>
			@endforeach
		</select>
		
		<?php
		} else {
			echo $href;
		}
		?>
					</td>
					<td>{!! (!is_null($crl->belongtostaffleavereplacement))?Carbon::parse($crl->belongtostaffleavereplacement->updated_at)->format('D, j M Y'):NULL !!}</td>
					<td>{!! (!is_null($crl->belongtostaffleavereplacement))?Carbon::parse($crl->belongtostaffleavereplacement->working_date)->format('D, j M Y'):NULL !!}</td>
					<td>{!! (!is_null($crl->belongtostaffleavereplacement))?$crl->belongtostaffleavereplacement->working_location:NULL !!}</td>
					<td>{!! (!is_null($crl->belongtostaffleavereplacement))?$crl->belongtostaffleavereplacement->working_reason:NULL !!}</td>
					<td>{!! (!is_null($crl->belongtostaffleavereplacement))?$crl->belongtostaffleavereplacement->remarks:NULL !!}</td>
					<td>{!! (!is_null($crl->belongtostaffleavereplacement))?$crl->belongtostaffleavereplacement->leave_total:NULL !!} day/s</td>
					<td>{!! (!is_null($crl->belongtostaffleavereplacement))?$crl->belongtostaffleavereplacement->leave_utilize:NULL !!} day/s</td>
					<td>{!! (!is_null($crl->belongtostaffleavereplacement))?$crl->belongtostaffleavereplacement->leave_balance:NULL !!} day/s</td>
				</tr>
		@endif
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
	</div>
</div>