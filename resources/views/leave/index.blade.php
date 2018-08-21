@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Staff Leaves Record</h1></div>
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
			<dd class="col-sm-9">{{ \Auth::user()->belongtostaff->hasmanystaffleave()->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [5, 6])->get()->count() }} days</dd>
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
<?php
$w = \Auth::user()->belongtostaff->gender_id;
$r = \Auth::user()->belongtostaff->mobile;
?>

		<p><a href="{{ ( empty($w) && empty($r) )?route('staff.edit', \Auth::user()->belongtostaff->id):route('staffLeave.create') }}" class="btn btn-primary">{{ ( empty($w) && empty($r) )?'Butiran Diri':'Leave Application' }}</a></p>
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

