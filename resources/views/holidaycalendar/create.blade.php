@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Add Holiday Calendar</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

{!! Form::open(['route' => ['holidayCalendar.store'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) !!}
	@include('holidaycalendar._form')
{{ Form::close() }}
		
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$(document).on('keyup', '#hol', function () {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
//date
$('#dstart').datetimepicker({
	format: 'YYYY-MM-DD',
	useCurrent: false, //Important! See issue #1075
})
.on("dp.change dp.show dp.update", function (e) {
	var minDate = $('#dstart').val();
	$('#dend').datetimepicker('minDate', minDate);
	$('#form').bootstrapValidator('revalidateField', 'date_start');
});


$('#dend').datetimepicker({
	format: 'YYYY-MM-DD',
	useCurrent: false, //Important! See issue #1075
})
.on("dp.change dp.show dp.update", function (e) {
	var maxDate = $('#dend').val();
	$('#dstart').datetimepicker('maxDate', maxDate);
	$('#form').bootstrapValidator('revalidateField', 'date_end');
});


/////////////////////////////////////////////////////////////////////////////////////////
// bootstrap validator

$('#form').bootstrapValidator({
	feedbackIcons: {
		valid: '',
		invalid: '',
		validating: ''
	},
	fields: {
		'date_start': {
			validators: {
				notEmpty: {
					message: 'Please insert holiday date start. '
				},
				date: {
					format: 'YYYY-MM-DD',
					message: 'Please insert holiday date start. '
				},
				remote: {
					type: 'POST',
					url: '{{ route('workinghour.hcaldstart') }}',
					message: 'The date is already exist. Please choose another date. ',
					data: function(validator) {
								return {
											_token: '{!! csrf_token() !!}',
											date_start: $('#dstart').val(),
								};
							},
					//delay: 1,		// wait 0.001 seconds
				},
			}
		},
		'date_end': {
			validators: {
				notEmpty: {
					message: 'Please insert holiday date end. '
				},
				date: {
					format: 'YYYY-MM-DD',
					message: 'Please insert holiday date end. '
				},
				remote: {
					type: 'POST',
					url: '{{ route('workinghour.hcaldend') }}',
					message: 'The date is already exist. Please choose another date. ',
					data: function(validator) {
								return {
											_token: '{!! csrf_token() !!}',
											date_end: $('#dend').val(),
								};
							},
					delay: 1,		// wait 0.001 seconds
				},
			}
		},
		'holiday': {
			validators: {
				notEmpty: {
					message: 'Please insert the name of the holiday. '
				}
			}
		},
	}
});

/////////////////////////////////////////////////////////////////////////////////////////
//add more row


/////////////////////////////////////////////////////////////////////////////////////////
@endsection

