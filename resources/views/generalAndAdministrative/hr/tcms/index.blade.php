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
<?php
$act = \App\Model\Staff::where('active', 1)->get();
$act1 = $act->count() - 2;
?>

/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$("#username").keyup(function() {
	uch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
$('.name1').popover({ 
	trigger: "hover",
	html: true,
});

/////////////////////////////////////////////////////////////////////////////////////////
// table
// https://datatables.net/blog/2014-12-18
// $.fn.dataTable.moment( 'HH:mm MMM D, YY' );
$.fn.dataTable.moment( 'ddd, D MMM YYYY' );

$('#attendance').DataTable({
	"lengthMenu": [ [{!! $act1 !!}, {!! $act1*2 !!}, {!! $act1*3 !!}, -1], [{!! $act1 !!}, {!! $act1*2 !!}, {!! $act1*3 !!}, "All"] ],
	"order": [[0, "desc" ]],	// sorting the 4th column descending
	// responsive: true
	// "ordering": false
});

/////////////////////////////////////////////////////////////////////////////////////////
// date
$('#dts').datetimepicker({
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
	$('#form').bootstrapValidator('revalidateField', 'date_start');

	var minDate = $('#dts').val();
	$('#dte').datetimepicker('minDate', minDate);
});

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
	$('#form').bootstrapValidator('revalidateField', 'date_end');
	var maxDate = $('#dte').val();
	$('#dts').datetimepicker('maxDate', maxDate);
});

/////////////////////////////////////////////////////////////////////////////////////////
// aajax for date attendance
// $('#search').on('click', function(e){
// 	e.preventDefault();
// 	console.log('click on button');
// });

/////////////////////////////////////////////////////////////////////////////////////////
$('#form').bootstrapValidator({
	group: '.input-group',
	feedbackIcons: {
		valid: '',
		invalid: '',
		validating: ''
	},
	fields: {
		date_start: {
			validators: {
				notEmpty: {
					message: 'Please insert date. '
				},
				date: {
					format: 'YYYY-MM-DD',
					message: 'Invalid format. '
				}
			}
		},
		date_end: {
			validators: {
				notEmpty: {
					message: 'Please insert date. '
				},
				date: {
					format: 'YYYY-MM-DD',
					message: 'Invalid format. '
				}
			}
		},
	},
});
@endsection

