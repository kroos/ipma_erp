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
				<a class="nav-link active" href="{{ route('staffManagement.index') }}">Staff Management</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('leaveEditing.index') }}">Leave</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('tcms.index') }}">TCMS</a>
			</li>
		</ul>

		<div class="card">
			<div class="card-header">Staff Management</div>
			<div class="card-body">

		@include('layouts.info')
		@include('layouts.errorform')

{{ Form::model( $staffHR, ['route' => ['staffHR.storeHR', $staffHR->id], 'method' => 'PATCH', 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) }}
	@include('generalAndAdministrative.hr.staffmanagement.staffHR._form_create_HR')
{{ Form::close() }}

			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// jquery chained
$('#department_id_1').chainedTo('#division_id_1');

/////////////////////////////////////////////////////////////////////////////////////////
// jquery chained
$('#position_id_1').chainedTo('#department_id_1');

/////////////////////////////////////////////////////////////////////////////////////////
//select2
$('#division_id_1').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
//select2
$('#department_id_1').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
//select2
$('#position_id_1').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
// add position : add and remove row
<?php
$divs = \App\Model\Division::all();
$depts = \App\Model\Department::all();
$poss = \App\Model\Position::all();
?>

var max_fields      = 3; //maximum input boxes allowed
var add_buttons	= $(".add_position");
var wrappers	= $(".position_wrap");

var xs = 1;
$(add_buttons).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(xs < max_fields){
		xs++;
		wrappers.append(

			'<div class="rowposition">' +
				'<div class="row col-sm-12">' +
					'<div class="col-sm-1">' +
						'<button class="btn btn-danger remove_position" type="button">' +
							'<i class="fas fa-trash" aria-hidden="true"></i>' +
						'</button>' +
					'</div>' +
					'<div class="col-sm-2">' +
						'<label for="pos" class="col-form-label">Position</label>' +
					'</div>' +
					'<div class="col-sm-1">' +
						'<div class="form-group {{ $errors->has('staff.*.main') ? 'has-error' : '' }}">' +
							'<input class="form-check-input" type="radio" name="staff[][main]" id="main_' + xs + '" value="1" ><label for="main_' + xs + '">Main Position</label>' +
						'</div>' +
					'</div>' +
					'<div class="col-sm-2">' +
						'<div class="form-group {{ $errors->has('staff.*.division_id') ? 'has-error' : '' }}">' +
							'<select name="staff[' + xs + '][division_id]" id="division_id_' + xs + '" class="form-control">' +
@foreach($divs as $di)
								'<option value="{{ $di->id }}">{{ $di->division }}</option>' +
@endforeach
							'</select>' +
						'</div>' +
					'</div>' +
					'<div class="col-sm-2">' +
						'<div class="form-group {{ $errors->has('staff.*.department_id') ? 'has-error' : '' }}">' +
							'<select name="staff[' + xs + '][department_id]" id="department_id_' + xs + '" class="form-control">' +
@foreach($depts as $de)
								'<option value="{{ $de->id }}" data-chained="{{ $de->division_id }}">{{ $de->department }}</option>' +
@endforeach
							'</select>' +
						'</div>' +
					'</div>' +
					'<div class="col-sm-3">' +
						'<div class="form-group {{ $errors->has('staff.*.position_id') ? 'has-error' : '' }}">' +
							'<select name="staff[' + xs + '][position_id]" id="position_id_' + xs + '" class="form-control">' +
@foreach($poss as $po)
								'<option value="{{ $po->id }}" data-chained="{{ $po->department_id }}">{{ $po->position }}</option>' +
@endforeach
							'</select>' +
						'</div>' +
					'</div>' +
				'</div>' +
			'</div>'

		); //add input box

		console.log(xs);

		$('#department_id_' + xs).chainedTo('#division_id_' + xs);
		$('#position_id_' + xs).chainedTo('#department_id_' + xs);

		$('#division_id_' + xs).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});
		
		$('#department_id_' + xs).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});
		
		$('#position_id_' + xs).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});
	
		//bootstrap validate
		$('#form').bootstrapValidator('addField',	$('.rowposition')	.find('[name="staff[][main]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowposition')	.find('[name="staff['+ xs +'][division_id]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowposition')	.find('[name="staff['+ xs +'][department_id]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowposition')	.find('[name="staff['+ xs +'][position_id]"]'));
	}
});

$(wrappers).on("click",".remove_position", function(e){
	//user click on remove text
	e.preventDefault();
	//var $row = $(this).parent('.rowposition');
	var $row = $(this).parent().parent().parent();
	var $option1 = $row.find('[name="staff[][main]"]');
	var $option3 = $row.find('[name="staff[' + xs + '][division_id]"]');
	var $option4 = $row.find('[name="staff[' + xs + '][department_id]"]');
	var $option5 = $row.find('[name="staff[' + xs + '][position_id]"]');
	$row.remove();

	$('#form').bootstrapValidator('removeField', $option1);
	$('#form').bootstrapValidator('removeField', $option3);
	$('#form').bootstrapValidator('removeField', $option4);
	$('#form').bootstrapValidator('removeField', $option5);
	console.log(xs);
    xs--;
})

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
@for($i = 1; $i <= 3; $i++)
			'staff[][main]': {
				validators: {
					notEmpty: {
						message: 'Please select. '
					}
				}
			},
			'staff[{{ $i }}][division_id]': {
				validators : {
					notEmpty: {
						message: 'Please choose. '
					},
				}
			},
			'staff[{{ $i }}][department_id]': {
				validators : {
					notEmpty: {
						message: 'Please choose. '
					},
				}
			},
			'staff[{{ $i }}][position_id]': {
				validators : {
					notEmpty: {
						message: 'Please choose. '
					},
				}
			},
@endfor
		}
	})
	.find('[name="reason"]')
	// .ckeditor()
	// .editor
	//	.on('change', function() {
	//		// Revalidate the bio field
	//	$('#form').bootstrapValidator('revalidateField', 'reason');
	//	console.log($('#reason').val());
	//})
	;
});

/////////////////////////////////////////////////////////////////////////////////////////


@endsection

