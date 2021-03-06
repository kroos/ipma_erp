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

{{ Form::model( $staffHR, ['route' => ['staffHR.updateHR', $staffHR->id], 'method' => 'PATCH', 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) }}
	@include('generalAndAdministrative.hr.staffmanagement.staffHR._form_edit_HR')
{{ Form::close() }}
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// jquery chained to
	$('#lid').select2({
		placeholder: 'Please choose',
		allowClear: true,
		closeOnSelect: true,
		width: '100%',
	});

<?php
$a=0;
$b=0;
$c=0;
$d=0;
$e=0;
$f=0;
$g=0;
$h=0;
$i=0;
$j=0;
?>
@foreach($staffHR->belongtomanyposition()->orderBy('staff_positions.main', 'desc')->get() as $val)
	$('#department_id_{{ $a++ }}').chainedTo('#division_id_{{ $b++ }}');
	$('#position_id_{{ $d++ }}').chainedTo('#department_id_{{ $c++ }}');

	$('#division_id_{{ $e++ }}').select2({
		placeholder: 'Please choose',
		allowClear: true,
		closeOnSelect: true,
		width: '100%',
	});
	
	$('#department_id_{{ $f++ }}').select2({
		placeholder: 'Please choose',
		allowClear: true,
		closeOnSelect: true,
		width: '100%',
	});
	
	$('#position_id_{{ $g++ }}').select2({
		placeholder: 'Please choose',
		allowClear: true,
		closeOnSelect: true,
		width: '100%',
	});
@endforeach
/////////////////////////////////////////////////////////////////////////////////////////
// add position : add and remove row
<?php
$divs = \App\Model\Division::all();
$depts = \App\Model\Department::all();
$poss = \App\Model\Position::all();
?>

var max_fields	= 3; //maximum input boxes allowed
var add_buttons	= $(".add_position");
var wrappers	= $(".position_wrap");

@if( $a > 0 )
var xs = 0;
@else
var xs = -1;
@endif
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
							'<input class="form-check-input" type="radio" name="staff[][main]" id="main_' + xs + '" value="1" required><label for="main_' + xs + '">Main Position</label>' +
						'</div>' +
					'</div>' +
					'<div class="col-sm-2">' +
						'<div class="form-group {{ $errors->has('staff.*.division_id') ? 'has-error' : '' }}">' +
							'<select name="staff[' + xs + '][division_id]" id="division_id_' + xs + '" class="form-control">' +
								'<option value="">Please choose</option>' +
@foreach($divs as $di)
								'<option value="{{ $di->id }}">{{ $di->division }}</option>' +
@endforeach
							'</select>' +
						'</div>' +
					'</div>' +
					'<div class="col-sm-2">' +
						'<div class="form-group {{ $errors->has('staff.*.department_id') ? 'has-error' : '' }}">' +
							'<select name="staff[' + xs + '][department_id]" id="department_id_' + xs + '" class="form-control">' +
								'<option value="">Please choose</option>' +
@foreach($depts as $de)
								'<option value="{{ $de->id }}" data-chained="{{ $de->division_id }}">{{ $de->department }}</option>' +
@endforeach
							'</select>' +
						'</div>' +
					'</div>' +
					'<div class="col-sm-3">' +
						'<div class="form-group {{ $errors->has('staff.*.position_id') ? 'has-error' : '' }}">' +
							'<select name="staff[' + xs + '][position_id]" id="position_id_' + xs + '" class="form-control">' +
								'<option value="">Please choose</option>' +
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
// ajax post delete row
$(document).on('click', '.delete_position', function(e){
	var productId = $(this).data('id');
	SwalDelete(productId);
	e.preventDefault();
});

function SwalDelete(productId){
	swal({
		title: 'Are you sure?',
		text: "It will be deleted permanently!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: '{{ url('staffHR') }}' + '/' + productId,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: productId,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_product_' + productId).parent().parent().remove();
				})
				.fail(function(){
					swal('Oops...', 'Something went wrong with ajax !', 'error');
				})
			});
		},
		allowOutsideClick: false			  
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal('Cancelled', 'Your data is safe from delete', 'info')
		}
	});
}

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
			'staff[][main]': {
				validators: {
					notEmpty: {
						message: 'Please select. '
					}
				}
			},
<?php
$t1 = 0;
$t2 = 0;
$t3 = 0;
?>
@for( $q1=0; $q1<=3; $q1++ )
			'staff[{{ $t1++ }}][division_id]': {
				validators : {
					notEmpty: {
						message: 'Please choose. '
					},
				}
			},
			'staff[{{ $t2++ }}][department_id]': {
				validators : {
					notEmpty: {
						message: 'Please choose. '
					},
				}
			},
			'staff[{{ $t3++ }}][position_id]': {
				validators : {
					notEmpty: {
						message: 'Please choose. '
					},
				}
			},
@endfor
		}
	})
	// .find('[name="reason"]')
	// .ckeditor()
	// .editor
	//	.on('change', function() {
		// Revalidate the bio field
	//	$('#form').bootstrapValidator('revalidateField', 'reason');
	//	console.log($('#reason').val());
	// })
	;
});

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

