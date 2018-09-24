@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1 class="card-title">Working Hours</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')
{{ Form::model($workingHour, ['route' => ['workingHour.update', $workingHour->id], 'method' => 'PATCH', 'id' => 'form', 'class' => 'form-horizontal', 'autocomplete' => 'off', 'files' => true]) }}
	@include('generalAndAdministrative.hr.hrsettings.workinghour._form')
{{ Form::close() }}
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// time
$('#tsa').datetimepicker({
	format: 'h:mm A',
	enabledHours: [8, 9, 10, 11, 12],
	useCurrent: false, //Important! See issue #1075
})
.on('dp.change dp.show dp.update', function(){
	$('#form').bootstrapValidator('revalidateField', 'time_start_am');
});

$('#tea').datetimepicker({
	format: 'h:mm A',
	enabledHours: [8, 9, 10, 11, 12],
	useCurrent: false, //Important! See issue #1075
})
.on('dp.change dp.show dp.update', function(){
	$('#form').bootstrapValidator('revalidateField', 'time_end_am');
});

$('#tsp').datetimepicker({
	format: 'h:mm A',
	enabledHours: [13, 14, 15, 16, 17],
	useCurrent: false, //Important! See issue #1075
})
.on('dp.change dp.show dp.update', function(){
	$('#form').bootstrapValidator('revalidateField', 'time_start_pm');
});

$('#tep').datetimepicker({
	format: 'h:mm A',
	enabledHours: [13, 14, 15, 16, 17],
	useCurrent: false, //Important! See issue #1075
})
.on('dp.change dp.show dp.update', function(){
	$('#form').bootstrapValidator('revalidateField', 'time_end_pm');
});

/////////////////////////////////////////////////////////////////////////////////////////
$('#eds').datetimepicker({
	format: 'YYYY-MM-DD',
	useCurrent: false, // Important! See issue #1075
})
.on('dp.change dp.show dp.update', function(){
	var mintar = $('#eds').val();
	$('#ede').datetimepicker( 'minDate', mintar );
	$('#form').bootstrapValidator('revalidateField', 'effective_date_start');
});

$('#ede').datetimepicker({
	format: 'YYYY-MM-DD',
	useCurrent: false, // Important! See issue #1075
})
.on('dp.change dp.show dp.update', function(){
	var maxtar = $('#ede').val();
	$('#eds').datetimepicker( 'maxDate', maxtar );
	$('#form').bootstrapValidator('revalidateField', 'effective_date_end');
});

/////////////////////////////////////////////////////////////////////////////////////////
// validator
$(document).ready(function() {
	$('#form').bootstrapValidator({
		feedbackIcons: {
			valid: '',
			invalid: '',
			validating: ''
		},
		fields: {
			time_start_am: {
				validators: {
					notEmpty: {
						message: 'Please insert time',
					},
					regexp: {
						regexp: /^([1-5]|[8-9]|1[0-2]):([0-5][0-9])\s([A|P]M|[a|p]m)$/i,
						message: 'The value is not a valid time',
					}
				}
			},
			time_end_am: {
				validators: {
					notEmpty: {
						message: 'Please insert time',
					},
					regexp: {
						regexp: /^([1-5]|[8-9]|1[0-2]):([0-5][0-9])\s([A|P]M|[a|p]m)$/i,
						message: 'The value is not a valid time',
					}
				}
			},
			time_start_pm: {
				validators: {
					notEmpty: {
						message: 'Please insert time',
					},
					regexp: {
						regexp: /^([1-5]|[8-9]|1[0-2]):([0-5][0-9])\s([A|P]M|[a|p]m)$/i,
						message: 'The value is not a valid time',
					}
				}
			},
			time_end_pm: {
				validators: {
					notEmpty: {
						message: 'Please insert time',
					},
					regexp: {
						regexp: /^([1-5]|[8-9]|1[0-2]):([0-5][0-9])\s([A|P]M|[a|p]m)$/i,
						message: 'The value is not a valid time',
					}
				}
			},
			effective_date_start: {
				validators: {
					notEmpty : {
						message: 'Please insert date start'
					},
					date: {
						format: 'YYYY-MM-DD',
						message: 'The value is not a valid date. '
					},
				}
			},
			effective_date_end: {
				validators: {
					notEmpty : {
						message: 'Please insert date end'
					},
					date: {
						format: 'YYYY-MM-DD',
						message: 'The value is not a valid date. '
					},
				}
			},
		}
	})
	// .find('[name="reason"]')
	// .ckeditor()
	// .editor
	// 	.on('change', function() {
	// 		// Revalidate the bio field
	// 	$('#form').bootstrapValidator('revalidateField', 'reason');
	// 	// console.log($('#reason').val());
	// })
	;
});

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

