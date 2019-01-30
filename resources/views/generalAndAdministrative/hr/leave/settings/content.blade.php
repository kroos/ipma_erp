<?php
use \App\Model\Staff;
use \App\Model\StaffAnnualMCLeave;

use \Carbon\Carbon;

$n = Carbon::now();

$s1 = StaffAnnualMCLeave::where('year', $n->year)->get();
$s2 = StaffAnnualMCLeave::where('year', $n->copy()->addYear()->year)->get();
?>
<ul class="nav nav-pills">
	<li class="nav-item">
		<a class="nav-link active" href="{{ route('leaveSetting.index') }}">Settings</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('leaveNRL.index') }}">Non Record Leave</a>
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
	<div class="card-header">List of Staff Annual Leave, Medical Certificate Leave And Maternity Leave.</div>
	<div class="card-body">

		<table class="table table-hover table-sm" id="almcml1" style="font-size:12px">
			<thead>
				<tr>
					<th colspan="11"><h3>List of Staff Annual Leave, Medical Certificate Leave and Maternity Leave Year {!! $n->year !!}.</h3></th>
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
@foreach($s1 as $k)
@if( $k->belomgtostaff->id != 191 && $k->belomgtostaff->id != 192 && $k->belomgtostaff->active == 1 )
				<tr>
					<td>{!! $k->belomgtostaff->hasmanylogin()->where('active', 1)->first()->username !!}</td>
					<td>{{ $k->belomgtostaff->name }}</td>
					<td>{{ $k->year }}</td>
					<td>{{ $k->annual_leave }}</td>
					<td>{{ $k->annual_leave_balance }}</td>
					<td>{{ $k->medical_leave }}</td>
					<td>{{ $k->medical_leave_balance }}</td>
					<td>{{ ($k->belomgtostaff->gender_id == 1 )?NULL:$k->maternity_leave }}</td>
					<td>{{ ($k->belomgtostaff->gender_id == 1 )?NULL:$k->maternity_leave_balance }}</td>
					<td>{{ $k->remarks }}</td>
					<td>
						<a href="{{ route('staffAnnualMCLeave.edit', $k->id) }}" title="Edit" class=""><i class="far fa-edit"></i></a>
						<span title="Delete" class="text-danger delete_almcml" id="delete_almcml_{!! $k->id !!}" data-id="{!! $k->id !!}"><i class="fas fa-trash" aria-hidden="true"></i></span>
					</td>
				</tr>
@endif
@endforeach
			</tbody>
		</table>
		<p>&nbsp;</p>
@if(StaffAnnualMCLeave::where('year', $n->copy()->addYear()->year)->count() > 0 )
		<table class="table table-hover table-sm" id="almcml2" style="font-size:12px">
			<thead>
				<tr>
					<th colspan="11"><h3>List of Staff Annual Leave, Medical Certificate Leave and Maternity Leave Year {!! $n->copy()->addYear()->year !!}.</h3></th>
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
@foreach($s2 as $k)
@if( $k->belomgtostaff->id != 191 && $k->belomgtostaff->id != 192 && $k->belomgtostaff->active == 1 )
<?php
	$year = $k->year;
	$annual_leave = $k->annual_leave;
	$annual_leave_balance = $k->annual_leave_balance;
	$medical_leave = $k->medical_leave;
	$medical_leave_balance = $k->medical_leave_balance;
	$maternity_leave = $k->maternity_leave;
	$maternity_leave_balance = $k->maternity_leave_balance;
	$remarks = $k->remarks;
?>
				<tr>
					<td>{{ $k->belomgtostaff->hasmanylogin()->where('active', 1)->first()->username }}</td>
					<td>{{ $k->belomgtostaff->name }}</td>
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
			</tbody>
		</table>
@else
	<p><h3>No data for Year {!! $n->copy()->addYear()->year !!}</h3></p>
	<p>It is adviseable to use this button at the end of the year (early december if possible). This button will automatically generate all the annual leave, medical certificate leave including maternity leave for the next year <strong>ONLY</strong> for <strong>currently active staff</strong>. If there is new staff intake after this button is used before this year end , please use button <strong>"Create New AL, MC or ML for User In Year {!! $n->copy()->addYear()->year !!}"</strong> to create his/her AL, MC and ML for the next year.</p>
	<p><button type="submit" class="btn btn-primary" id="galmcml" data-id="{{ $n->copy()->addYear()->year }}">Generate Annual, Medical Leave for Year {!! $n->copy()->addYear()->year !!}</button></p>
@endif
	<p>Please use this button if there is NO "Generate Annual, Medical Leave for Year {!! $n->copy()->addYear()->year !!}" button AND before the year ({!! $n->copy()->addYear()->year !!}) end.</p>
	<p><a href="{!! route('staffAnnualMCLeave.create') !!}" class="btn btn-primary">Create New AL, MC or ML for User In Year {!! $n->copy()->addYear()->year !!}</a></p>

	</div>
</div>