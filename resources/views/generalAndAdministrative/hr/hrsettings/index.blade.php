@extends('layouts.app')

@section('content')
<?php
// load model
use App\Model\HumanResource\HRSettings\WorkingHour;
use App\Model\HolidayCalendar;

// penting sgt nihhh.. carbon niiii..
use \Carbon\Carbon;

$yp = WorkingHour::groupBy('year')->select('year')->get();
$yhc = HolidayCalendar::groupBy('yaer')->selectRaw('YEAR(date_start) as yaer')->get();
// echo $yhc.' year<br />';
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
		<div class="card-body table-responsive">
			<table class="table table-hover" style="font-size:12px">
@foreach($yp as $tp)
				<thead>
					<tr>
						<th class="text-center" colspan="8">Normal Working Hours ({{ $tp->year }})</th>
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
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
@foreach(WorkingHour::where('maintenance', 0)->where('year', $tp->year)->orderBy('year')->orderBy('effective_date_start')->get() as $t)
					<tr>
						<td>{{ $t->year }}</td>
						<td>{{ Carbon::parse($t->time_start_am)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->time_end_am)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->time_start_pm)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->time_end_pm)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->effective_date_start)->format('D, j M Y') }}</td>
						<td>{{ Carbon::parse($t->effective_date_end)->format('D, j M Y') }}</td>
						<td>{{ $t->remarks }}</td>
						<td> <a class="btn btn-primary" href="{{ route('workingHour.edit', $t->id) }}"><i class="far fa-edit"></i></a> </td>
					</tr>
@endforeach
				</tbody>
				<thead>
					<tr>
						<th class="text-center" colspan="8">Maintenance Working Hours {{ $tp->year }}</th>
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
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
@foreach(WorkingHour::where('maintenance', 1)->where('year', $tp->year)->orderBy('year')->orderBy('effective_date_start')->get() as $t)
					<tr>
						<td>{{ $t->year }}</td>
						<td>{{ Carbon::parse($t->time_start_am)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->time_end_am)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->time_start_pm)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->time_end_pm)->format('g:i a') }}</td>
						<td>{{ Carbon::parse($t->effective_date_start)->format('D, j M Y') }}</td>
						<td>{{ Carbon::parse($t->effective_date_end)->format('D, j M Y') }}</td>
						<td>{{ $t->remarks }}</td>
						<td> <a class="btn btn-primary" href="{{ route('workingHour.edit', $t->id) }}"><i class="far fa-edit"></i></a> </td>
					</tr>
@endforeach
				</tbody>
@endforeach
			</table>
		</div>
		<div class="card-footer">
			 <a href="{{ route('workingHour.create') }}" class="btn btn-primary float-right">Add Working Hour</a>
		</div>
	</div>
		<br />
		<div class="card">
			<div class="card-header">Public Holiday For {{ config('app.name') }}</div>
			<div class="card-body table-responsive">
				<table class="table table-hover" style="font-size:12px">
@foreach($yhc as $hi)
@if($hi->yaer >= date('Y'))
					<thead>
						<tr>
							<th class="text-center" colspan="4">Public Holiday ({{ $hi->yaer }})</th>
						</tr>
						<tr>
							<th>From</th>
							<th>To</th>
							<th>Holiday</th>
							<th>Period</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
<?php
$kj = HolidayCalendar::whereYear('date_start', $hi->yaer)->get();
// echo $kj.' date based year<br />';
?>
@foreach( $kj as $ui )
						<tr>
							<td>{{ Carbon::parse($ui->date_start)->copy()->format('D, j F Y') }}</td>
							<td>{{ Carbon::parse($ui->date_end)->copy()->format('D, j F Y') }}</td>
							<td>{{ ucwords(strtolower($ui->holiday)) }}</td>
							<td>{{ \Carbon\CarbonPeriod::create($ui->date_start, '1 day', $ui->date_end)->count().__(' Day/s') }}</td>
							<td>
								<a class="btn btn-primary" href="{{ route('holidayCalendar.edit', $ui->id) }}"><i class="far fa-edit"></i></a>
								<a class="btn btn-primary" href="{{ route('holidayCalendar.destroy', $ui->id) }}"><i class="far fa-trash-alt"></i></a>
							</td>
						</tr>
@endforeach
					</tbody>
@endif
@endforeach
				</table>
			</div>
			<div class="card-footer">
				<a href="{{ route('holidayCalendar.create') }}" class="btn btn-primary float-right">Add Public Holiday</a>
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

