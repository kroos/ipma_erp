@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Human Resource Department</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

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
				<a class="nav-link" href="{{ route('leaveEditing.index') }}">Leave</a>
			</li>
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('tcms.index') }}">TCMS</a>
			</li>
		</ul>

		<div class="card">
			<div class="card-header">TCMS Management</div>
			<div class="card-body">
				@include('generalAndAdministrative.hr.tcms.content')
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
// date
$('#dte').datetimepicker({
	format: 'YYYY-MM-DD',
	useCurrent: false,
	daysOfWeekDisabled: [0],
	disabledDates: 
		[
			<?php
				// block holiday tgk dlm disable date in datetimepicker
				$nodate = \App\Model\HolidayCalendar::orderBy('date_start')->get();
				foreach ($nodate as $nda) {
					$period = \Carbon\CarbonPeriod::create($nda->date_start, '1 days', $nda->date_end);
					foreach ($period as $key) {
						echo 'moment("'.$key->format('Y-m-d').'"),';
						// $holiday[] = $key->format('Y-m-d');
					}
				}
			?>
		],
})
.on('dp.change dp.show dp.update', function() {
	$('#form').bootstrapValidator('revalidateField', 'date');
});

/////////////////////////////////////////////////////////////////////////////////////////
// aajax for date attendance
$('#search').on('click', function(e){
	e.preventDefault();
	console.log('click on button');
});

/////////////////////////////////////////////////////////////////////////////////////////
$('#form').bootstrapValidator({
	group: '.input-group',
	feedbackIcons: {
		valid: '',
		invalid: '',
		validating: ''
	},
	fields: {
		date: {
			validators: {
				notEmpty: {
					message: 'Please insert date. '
				},
				date: {
					format: 'YYYY-MM-DD',
					message: 'Invalid format. '
				}
			}
		}
	},
});
@endsection

