@extends('layouts.app')

@section('content')
<?php
// load model
use App\Model\HumanResource\HRSettings\WorkingHour;

// penting sgt nihhh.. carbon niiii..
use \Carbon\Carbon;
?>
<div class="card">
	<div class="card-header"><h1>Human Resource Department</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<ul class="nav nav-tabs">
@foreach( App\Model\Division::find(1)->hasmanydepartment()->get() as $key)
			<li class="nav-item">
				<a class="nav-link {{ ($key->id == 3)? 'active' : 'disabled' }}" href="{{ route("$key->route.index") }}">{{ $key->department }}</a>
			</li>
@endforeach
		</ul>

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('hrSettings.index') }}">Settings</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('staffManagement.index') }}">Staff Management</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('leaveEditing.index') }}">Leave</a>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="{{ route('tcms.index') }}">TCMS</a>
			</li>
		</ul>

<div class="card">
	<div class="card-header">Human Resource Settings</div>
	<div class="card-body">

	<div class="card">
		<div class="card-header">Working Hours</div>
		<div class="card-body">
			<table class="table table-hover" style="font-size:12px">
				<thead>
					<tr>
						<th colspan="8">Normal Working Hours</th>
					</tr>
					<tr>
						<th>Year</th>
						<th>Time Start AM</th>
						<th>Time End AM</th>
						<th>Time Start PM</th>
						<th>Time End PM</th>
						<th>Effective Date From</th>
						<th>Effective Date To</th>
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody>
@foreach(WorkingHour::where('maintenance', 0)->where('year', '>=', date('Y'))->orderBy('year')->orderBy('effective_date_start')->get() as $t)
					<tr>
						<td>{{ $t->year }}</td>
						<td>{{ Carbon::parse($t->time_start_am)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->time_end_am)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->time_start_pm)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->time_end_pm)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->effective_date_start)->format('D, j M Y') }}</td>
						<td>{{ Carbon::parse($t->effective_date_end)->format('D, j M Y') }}</td>
						<td>{{ $t->remarks }}</td>
					</tr>
@endforeach
				</tbody>
				<thead>
					<tr>
						<th colspan="8">Maintenance Working Hours</th>
					</tr>
					<tr>
						<th>Year</th>
						<th>Time Start AM</th>
						<th>Time End AM</th>
						<th>Time Start PM</th>
						<th>Time End PM</th>
						<th>Effective Date From</th>
						<th>Effective Date To</th>
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody>
@foreach(WorkingHour::where('maintenance', 1)->where('year', '>=', date('Y'))->orderBy('year')->orderBy('effective_date_start')->get() as $t)
					<tr>
						<td>{{ $t->year }}</td>
						<td>{{ Carbon::parse($t->time_start_am)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->time_end_am)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->time_start_pm)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->time_end_pm)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->effective_date_start)->format('D, j M Y') }}</td>
						<td>{{ Carbon::parse($t->effective_date_end)->format('D, j M Y') }}</td>
						<td>{{ $t->remarks }}</td>
					</tr>
@endforeach
				</tbody>
			</table>
		</div>
	</div>


	</div>
</div>












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
@endsection

