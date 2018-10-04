@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Human Resource Department</h1></div>
	<div class="card-body">

		<ul class="nav nav-tabs">
@foreach( App\Model\Division::find(1)->hasmanydepartment()->whereNotIn('id', [22, 23, 24])->get() as $key)
			<li class="nav-item">
				<a class="nav-link {{ ($key->id == 3)? 'active' : 'disabled' }}" href="{{ route("$key->route.index") }}">{{ $key->department }}</a>
			</li>
@endforeach
		</ul>

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link " href="{{ route('hrSettings.index') }}">Settings</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('staffManagement.index') }}">Staff Management</a>
			</li>
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('leaveEditing.index') }}">Leave</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('tcms.index') }}">TCMS</a>
			</li>
		</ul>

		<div class="card">
			<div class="card-header">Leaves Management</div>
			<div class="card-body">
				{{ Form::model($staffLeaveHR, ['route' => ['staffLeaveHR.update', $staffLeaveHR->id], 'method' => 'PATCH', 'id' => 'form', 'class' => 'form-horizontal', 'autocomplete' => 'off', 'files' => true]) }}
					@include('generalAndAdministrative.hr.leave.leavelist._form_editHR')
				{{ Form::close() }}
			</div>
		</div>

	</div>
</div>
@endsection

@section('js')
<?php
// block holiday tgk dlm disable date in datetimepicker
$nodate = \App\Model\HolidayCalendar::orderBy('date_start')->get();
// block cuti sendiri
$nodate1 = $staffLeaveHR->belongtostaff->hasmanystaffleave()->where('active', 1)->where('active', 2)->whereRaw( '"'.date('Y').'" BETWEEN YEAR(date_time_start) AND YEAR(date_time_end)' )->get();
?>












/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$("#username").keyup(function() {
	uch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
// date time
$('#dts').datetimepicker({
	format: 'YYYY-MM-DD',
	useCurrent: false,
			daysOfWeekDisabled: [0],
			disabledDates: 
					[
<?php
// block holiday tgk dlm disable date in datetimepicker
	foreach ($nodate as $nda) {
		$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
		foreach ($period as $key) {
			echo 'moment("'.$key->format('Y-m-d').'"),';
			// $holiday[] = $key->format('Y-m-d');
		}
	}
	// block cuti sendiri
	foreach ($nodate1 as $key) {
		$period1 = \Carbon\CarbonPeriod::create($key->date_time_start, '1 days', $key->date_time_end);
		foreach ($period1 as $key1) {
			echo 'moment("'.$key1->format('Y-m-d').'"),';
			// $holiday[] = $key1->format('Y-m-d');
		}
	}
?>
					],

});

$('#dte').datetimepicker({
	format: 'YYYY-MM-DD',
	useCurrent: false,
			daysOfWeekDisabled: [0],
			disabledDates: 
					[
<?php
// block holiday tgk dlm disable date in datetimepicker
	foreach ($nodate as $nda) {
		$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
		foreach ($period as $key) {
			echo 'moment("'.$key->format('Y-m-d').'"),';
			// $holiday[] = $key->format('Y-m-d');
		}
	}
	// block cuti sendiri
	foreach ($nodate1 as $key) {
		$period1 = \Carbon\CarbonPeriod::create($key->date_time_start, '1 days', $key->date_time_end);
		foreach ($period1 as $key1) {
			echo 'moment("'.$key1->format('Y-m-d').'"),';
			// $holiday[] = $key1->format('Y-m-d');
		}
	}
?>
					],

});

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

