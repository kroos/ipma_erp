<?php
use \App\Model\Staff;
use \App\Model\StaffAnnualMCLeave;

use \Carbon\Carbon;

$n = Carbon::now();

$s = Staff::where('active', 1)->orderBy('name', 'asc')->get();
?>
<ul class="nav nav-pills">
	<li class="nav-item">
		<a class="nav-link active" href="{{ route('leaveSetting.index') }}">Settings</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('leaveNRL.index') }}">Non Replacement Leave</a>
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
	<div class="card-header">List of Staff Annual Leave, Medical Certificate Leave And Maternity Leave.</div>
	<div class="card-body">

		<table class="table table-hover table-sm" id="almcml1" style="font-size:12px">
			<thead>
				<tr>
					<th colspan="10"><h3>List of Staff Annual Leave, Medical Certificate Leave and Maternity Leave Year {!! $n->year !!}.</h3></th>
				</tr>
				<tr>
					<th>Staff ID</th>
					<th>Staff</th>
					<th>Year</th>
					<th>Annual Leave Initialize</th>
					<th>Annual Leave Balance</th>
					<th>Medical Leave Initialize</th>
					<th>Medical Leave Balance</th>
					<th>Maternity Leave Initialize</th>
					<th>Maternity Leave Balance</th>
					<th>Remarks</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
@foreach($s as $k)
@if( $k->belongtomanyposition()->wherePivot('main', 1)->first()->group_id != 1 )
				<tr>
					<td>{{ $k->hasmanylogin()->where('active', 1)->first()->username }}</td>
					<td>{{ $k->name }}</td>
					<td>{{ $k->hasmanystaffannualmcleave()->where('year', $n->year)->first()->year }}</td>
					<td>{{ $k->hasmanystaffannualmcleave()->where('year', $n->year)->first()->annual_leave }}</td>
					<td>{{ $k->hasmanystaffannualmcleave()->where('year', $n->year)->first()->annual_leave_balance }}</td>
					<td>{{ $k->hasmanystaffannualmcleave()->where('year', $n->year)->first()->medical_leave }}</td>
					<td>{{ $k->hasmanystaffannualmcleave()->where('year', $n->year)->first()->medical_leave_balance }}</td>
					<td>{{ ($k->gender_id == 1 )?NULL:$k->hasmanystaffannualmcleave()->where('year', $n->year)->first()->maternity_leave }}</td>
					<td>{{ ($k->gender_id == 1 )?NULL:$k->hasmanystaffannualmcleave()->where('year', $n->year)->first()->maternity_leave_balance }}</td>
					<td>{{ $k->hasmanystaffannualmcleave()->where('year', $n->year)->first()->remarks }}</td>
					<td>
						<a href="{{ route('staffAnnualMCLeave.edit', $k->id) }}" title="Edit" class="btn btn-primary"><i class="far fa-edit"></i></a>
						<button title="Delete" class="btn btn-danger delete_almcml" id="delete_almcml_{!! $k->id !!}" data-id="{!! $k->id !!}"><i class="fas fa-trash" aria-hidden="true"></i></button>
					</td>
				</tr>
@endif
@endforeach
			</tbody>
		</table>
		<p>&nbsp;</p>
		<table class="table table-hover table-sm" id="almcml2" style="font-size:12px">
			<thead>
				<tr>
					<th colspan="10"><h3>List of Staff Annual Leave, Medical Certificate Leave and Maternity Leave Year {!! $n->copy()->addYear()->year !!}.</h3></th>
				</tr>
				<tr>
					<th>Staff ID</th>
					<th>Staff</th>
					<th>Year</th>
					<th>Annual Leave Initialize</th>
					<th>Annual Leave Balance</th>
					<th>Medical Leave Initialize</th>
					<th>Medical Leave Balance</th>
					<th>Maternity Leave Initialize</th>
					<th>Maternity Leave Balance</th>
					<th>Remarks</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
@if(StaffAnnualMCLeave::where('year', $n->copy()->addYear()->year)->count() > 0 )
@foreach($s as $k)
@if( $k->belongtomanyposition()->wherePivot('main', 1)->first()->group_id != 1 )
<?php
if (!is_null( $k->hasmanystaffannualmcleave()->where('year', $n->copy()->addYear()->year)->first() )) {
	$year = $k->hasmanystaffannualmcleave()->where('year', $n->copy()->addYear()->year)->first()->year;
	$annual_leave = $k->hasmanystaffannualmcleave()->where('year', $n->copy()->addYear()->year)->first()->annual_leave;
	$annual_leave_balance = $k->hasmanystaffannualmcleave()->where('year', $n->copy()->addYear()->year)->first()->annual_leave_balance;
	$medical_leave = $k->hasmanystaffannualmcleave()->where('year', $n->copy()->addYear()->year)->first()->medical_leave;
	$medical_leave_balance = $k->hasmanystaffannualmcleave()->where('year', $n->copy()->addYear()->year)->first()->medical_leave_balance;
	$maternity_leave = $k->hasmanystaffannualmcleave()->where('year', $n->copy()->addYear()->year)->first()->maternity_leave;
	$maternity_leave_balance = $k->hasmanystaffannualmcleave()->where('year', $n->copy()->addYear()->year)->first()->maternity_leave_balance;
	$remarks = $k->hasmanystaffannualmcleave()->where('year', $n->copy()->addYear()->year)->first()->remarks;
} else {
	$year = NULL;
	$annual_leave = NULL;
	$annual_leave_balance = NULL;
	$medical_leave = NULL;
	$medical_leave_balance = NULL;
	$maternity_leave = NULL;
	$maternity_leave_balance = NULL;
	$remarks = NULL;
}
?>
				<tr>
					<td>{{ $k->hasmanylogin()->where('active', 1)->first()->username }}</td>
					<td>{{ $k->name }}</td>
					<td>{{ $year }}</td>
					<td>{{ $annual_leave }}</td>
					<td>{{ $annual_leave_balance }}</td>
					<td>{{ $medical_leave }}</td>
					<td>{{ $medical_leave_balance }}</td>
					<td>{{ ($k->gender_id == 1 )?NULL:$maternity_leave }}</td>
					<td>{{ ($k->gender_id == 1 )?NULL:$maternity_leave_balance }}</td>
					<td>{{ $remarks }}</td>
					<td>
						<a href="{{ route('staffAnnualMCLeave.edit', $k->id) }}" title="Edit" class="btn btn-primary"><i class="far fa-edit"></i></a>
						<button title="Delete" class="btn btn-danger delete_almcml" id="delete_almcml_{!! $k->id !!}" data-id="{!! $k->id !!}"><i class="fas fa-trash" aria-hidden="true"></i></button>
					</td>
				</tr>
@endif
@endforeach
@else
<tr>
	<td colspan="10"><h6>No data for Year {!! $n->copy()->addYear()->year !!}</h6></td>
</tr>
@endif
			</tbody>
		</table>




	</div>
</div>