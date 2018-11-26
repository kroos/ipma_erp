@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Customer Service Department</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<ul class="nav nav-tabs">
@foreach( App\Model\Division::find(3)->hasmanydepartment()->whereNotIn('id', [22, 23, 24])->get() as $key)
			<li class="nav-item">
				<a class="nav-link {{ ($key->id == 10)? 'active' : 'disabled' }}" href="{{ route("$key->route.index") }}">{{ $key->department }}</a>
			</li>
@endforeach
		</ul>

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('serviceReport.index') }}">Intelligence Customer Service</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="">Cost Planning System</a>
			</li>
		</ul>
		<div class="card">
			<div class="card-header">Intelligence Customer Service</div>
			<div class="card-body">
				<div class="card">
					<div class="card-header">Update Service Report</div>
					<div class="card-body">
{!! Form::model( $serviceReport, ['route' => ['serviceReport.update', $serviceReport->id], 'method' => 'PATCH', 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) !!}

@include('marketingAndBusinessDevelopment.customerservice.ics._edit')
{{ Form::close() }}
					</div>
<!-- 					<div class="card-footer">
						<a href="{{ route('serviceReport.create') }}" class="btn btn-primary float-right">Add Service Report</a>
					</div>
 -->				</div>
			</div>
		</div>


	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$("#compby, #compl").keyup(function() {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
$(document).on('change', '#cust', function () {
	selectedOption = $('option:selected', this);
	var client = $('#attn');
	var address = $('#phone');

	$(client).text( selectedOption.data('pc') );
	$(address).text( selectedOption.data('phone') );
});

/////////////////////////////////////////////////////////////////////////////////////////
// table
$('#date').datetimepicker({
	format:'YYYY-MM-DD',
	useCurrent: false,
})
.on('dp.change dp.show dp.update', function() {
	$('#form').bootstrapValidator('revalidateField', 'date');
});

/////////////////////////////////////////////////////////////////////////////////////////
$('#cust').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

<?php
$iiii = 1;
?>
@foreach( $serviceReport->hasmanyattendees()->get() as $sra )
$('#staff_id_{!! $iiii++ !!}').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});
@endforeach

<?php
$iiiii = 1;
$iiiiii = 1;
$iiiiiii = 1;
$iiiiiiii = 1;
$iiiiiiiii = 1;
?>
@foreach( $serviceReport->hasmanymodel()->get() as $srmo )
$('#model_{!! $iiiii++ !!}').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

$("#test_run_machine_{{ $iiiiii++ }}").keyup(function() {
	tch(this);
});

$("#serial_no_{{ $iiiiiii++ }}").keyup(function() {
	tch(this);
});

$("#test_capacity_{{ $iiiiiiii++ }}").keyup(function() {
	tch(this);
});

$("#duration_{{ $iiiiiiiii++ }}").keyup(function() {
	tch(this);
});
@endforeach

<?php
$t = 1;
?>
@foreach($serviceReport->hasmanypart()->get() as $srp)
$("#part_accessory_{{ $t++ }}").keyup(function() {
	tch(this);
});
@endforeach
/////////////////////////////////////////////////////////////////////////////////////////
// add serial : add and remove row

var maxfserial	= 200; //maximum input boxes allowed
var addbtnserial	= $(".add_serial");
var wrapserial	= $(".serial_wrap");

var x = <?=($serviceReport->hasmanyserial()->get()->count() == 0)?1:$serviceReport->hasmanyserial()->get()->count() ?>;
$(addbtnserial).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(x < maxfserial){
		x++;
		wrapserial.append(
					'<div class="rowserial">' +
						'<div class="row col-sm-12">' +
							'<div class="col-sm-1 text-danger remove_serial"  data-id="' + x + '">' +
									'<i class="fas fa-trash" aria-hidden="true"></i>' +
							'</div>' +
							'<div class="col-sm-11">' +
								'<div class="form-group {{ $errors->has('sr.*.serial') ? 'has-error' : '' }}">' +
									'<input type="text" name="srs[' + x + '][serial]" value="{!! @$value !!}" class="form-control" id="serial_' + x + '" placeholder="Service Report No." autocomplete="off" />' +
								'</div>' +
							'</div>' +
						'</div>' +
					'</div>'
		); //add input box
		//bootstrap validate
		$('#form').bootstrapValidator('addField', $('.rowserial').find('[name="srs[' + x + '][serial]"]'));
		// console.log(x);
	}
});

$(wrapserial).on("click",".remove_serial", function(e){
	//user click on remove text
	var serId = $(this).data('id');
	e.preventDefault();
	//var $row = $(this).parent('.rowserial');
	var $row = $(this).parent().parent();
	var $optserial = $row.find('[name="sr[' + serId + '][serial]"]');
	// console.log('[name="sr[' + serId + '][serial]"]');
	$('#form').bootstrapValidator('removeField', $optserial);
	$row.remove();
    x--;
})

/////////////////////////////////////////////////////////////////////////////////////////
// add attendees : add and remove row
<?php
$staff = \App\Model\Staff::where('active', 1)->get();
?>

var max_fields	= 10; //maximum input boxes allowed
var add_buttons	= $(".add_position");
var wrappers	= $(".position_wrap");

var xs = <?= ($serviceReport->hasmanyattendees()->get()->count() == 0)?1:$serviceReport->hasmanyattendees()->get()->count() ?>;
$(add_buttons).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(xs < max_fields){
		xs++;
		wrappers.append(

					'<div class="rowposition">' +
						'<div class="row col-sm-12">' +
							'<div class="col-sm-1 text-danger">' +
									'<i class="fas fa-trash remove_position" aria-hidden="true" id="button_delete_' + xs + '" data-id="' + xs + '"></i>' +
							'</div>' +
							'<div class="col-sm-11">' +
								'<div class="form-group {{ $errors->has('sr.*.attended_by') ? 'has-error' : '' }}">' +
									'<select name="sr[' + xs + '][attended_by]" id="staff_id_' + xs + '" class="form-control">' +
										'<option value="">Please choose</option>' +
@foreach($staff as $st)
										'<option value="{!! $st->id !!}">{{ $st->hasmanylogin()->where('active', 1)->first()->username }} {{ $st->name }}</option>' +
@endforeach
									'</select>' +
								'</div>' +
							'</div>' +
						'</div>' +
					'</div>'

		); //add input box

		$('#staff_id_' + xs).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField',	$('.rowposition')	.find('[name="sr[' + xs + '][attended_by]"]'));
	}
});

$(wrappers).on("click",".remove_position", function(e){
	var posId = $(this).data('id');
	//user click on remove text
	e.preventDefault();
	//var $row = $(this).parent('.rowposition');
	var $row = $(this).parent().parent().parent();
	var $option1 = $row.find('[name="sr[' + posId + '][attended_by]"]');
	$row.remove();

	$('#form').bootstrapValidator('removeField', $option1);
	console.log(xs);
	xs--;
})

/////////////////////////////////////////////////////////////////////////////////////////
// add model : add and remove row
<?php
$model = \App\Model\ICSMachineModel::get();
?>

var maxfmod	= 10; //maximum input boxes allowed
var addbtnmod	= $(".add_model");
var wrapmodel	= $(".model_wrap");

var xmod = <?= ($serviceReport->hasmanymodel()->get()->count() == 0)?1:$serviceReport->hasmanymodel()->get()->count() ?>;
$(addbtnmod).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(xmod < maxfmod){
		xmod++;
		wrapmodel.append(
					'<div class="rowmodel">' +
						'<div class="row col-sm-12 form-inline">' +
							'<div class="col-sm-1 text-danger">' +
									'<i class="fas fa-trash remove_model" aria-hidden="true" id="delete_model_' + xmod + '" data-id="' + xmod + '"></i>' +
							'</div>' +
							'<div class="">' +
								'<div class="form-group {{ $errors->has('srmo.*.model_id') ? 'has-error' : '' }}">' +
									'<select name="srmo[' + xmod + '][model_id]" id="model_' + xmod + '" class="form-control form-control-sm" autocomplete="off" placeholder="Please choose">' +
										'<option value="">Please choose</option>' +
@foreach( $model as $mod )
										'<option value="{!! $mod->id !!}">{!! $mod->model !!}</option>' +
@endforeach
									'</select>' +
								'</div>' +
							'</div>' +
							'<div class="">' +
								'<div class="form-group {{ $errors->has('srmo.*.test_run_machine') ? 'has-error' : '' }}">' +
									'<input type="text" name="srmo[' + xmod + '][test_run_machine]" id="test_run_machine_' + xmod + '" class="form-control form-control-sm" autocomplete="off" placeholder="Test Run Machine" />' +
								'</div>' +
							'</div>' +
							'<div class="">' +
								'<div class="form-group {{ $errors->has('srmo.*.serial_no') ? 'has-error' : '' }}">' +
									'<input type="text" name="srmo[' + xmod + '][serial_no]" id="serial_no_' + xmod + '" class="form-control form-control-sm" autocomplete="off" placeholder="Serial No" />' +
								'</div>' +
							'</div>' +
							'<div class="">' +
								'<div class="form-group {{ $errors->has('srmo.*.test_capacity') ? 'has-error' : '' }}">' +
									'<input type="text" name="srmo[' + xmod + '][test_capacity]" id="test_capacity_' + xmod + '" class="form-control form-control-sm" autocomplete="off" placeholder="Test Capacity" />' +
								'</div>' +
							'</div>' +
							'<div class="">' +
								'<div class="form-group {{ $errors->has('srmo.*.duration') ? 'has-error' : '' }}">' +
									'<input type="text" name="srmo[' + xmod + '][duration]" id="duration_' + xmod + '" class="form-control form-control-sm" autocomplete="off" placeholder="Duration" />' +
								'</div>' +
							'</div>' +
						'</div>' +
					'</div>'
		); //add input box

		$('#model_' + xmod).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});

		$('#test_run_machine_' + xmod).keyup(function() {
			tch(this);
		});

		$('#serial_no_' + xmod).keyup(function() {
			tch(this);
		});

		$('#test_capacity_' + xmod).keyup(function() {
			tch(this);
		});

		$('#duration_' + xmod).keyup(function() {
			tch(this);
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField',	$('.rowmodel')	.find('[name="srmo[' + xmod + '][model_id]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowmodel')	.find('[name="srmo[' + xmod + '][test_run_machine]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowmodel')	.find('[name="srmo[' + xmod + '][serial_no]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowmodel')	.find('[name="srmo[' + xmod + '][test_capacity]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowmodel')	.find('[name="srmo[' + xmod + '][duration]"]'));
	}
});

$(wrapmodel).on("click",".remove_model", function(e){
	var modelId = $(this).data('id');
	//user click on remove text
	e.preventDefault();
	//var $row = $(this).parent('.rowmodel');
	var $row = $(this).parent().parent().parent();
	var $option1 = $row.find('[name="srmo[' + modelId + '][model_id]"]');
	var $option2 = $row.find('[name="srmo[' + modelId + '][test_run_machine]"]');
	var $option3 = $row.find('[name="srmo[' + modelId + '][serial_no]"]');
	var $option4 = $row.find('[name="srmo[' + modelId + '][test_capacity]"]');
	var $option5 = $row.find('[name="srmo[' + modelId + '][duration]"]');
	$row.remove();

	$('#form').bootstrapValidator('removeField', $option1);
	$('#form').bootstrapValidator('removeField', $option2);
	$('#form').bootstrapValidator('removeField', $option3);
	$('#form').bootstrapValidator('removeField', $option4);
	$('#form').bootstrapValidator('removeField', $option5);
	console.log(xmod);
	xmod--;
})

/////////////////////////////////////////////////////////////////////////////////////////
// add part & Accessories : add and remove row
var maxfpart	= 10; //maximum input boxes allowed
var addbtnpart	= $(".add_part");
var wrappart	= $(".part_wrap");

var xpart = <?= ($serviceReport->hasmanypart()->get()->count() == 0)?1:$serviceReport->hasmanypart()->get()->count() ?>;
$(addbtnpart).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(xpart < maxfpart){
		xpart++;
		wrappart.append(
					'<div class="rowpart">' +
						'<div class="row col-sm-12 form-inline">' +
							'<div class="col-sm-1 text-danger">' +
									'<i class="fas fa-trash remove_part" aria-hidden="true" id="delete_part_' + xpart + '" data-id="' + xpart + '"></i>' +
							'</div>' +
							'<div class="form-group {{ $errors->has('srp.*.part_accessory') ? 'has-error' : '' }}">' +
								'<input type="text" name="srp[' + xpart + '][part_accessory]" value="{!! (!empty($srp->part_accessory))?$srp->part_accessory:@$value !!}" id="part_accessory_' + xpart + '" class="form-control" autocomplete="off" placeholder="Parts & Accessories" />' +
							'</div>' +
							'<div class="form-group {{ $errors->has('srp.*.qty') ? 'has-error' : '' }}">' +
								'<input type="text" name="srp[' + xpart + '][qty]" value="{!! (!empty($srp->qty))?$srp->qty:@$value !!}" id="qty_' + xpart + '" class="form-control" autocomplete="off" placeholder="Quantity" />' +
							'</div>' +
						'</div>' +
					'</div>'
		); //add input box

		$('#part_accessory_' + xpart).keyup(function() {
			tch(this);
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField',	$('.rowmodel')	.find('[name="srp[' + xpart + '][part_accessory]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowmodel')	.find('[name="srp[' + xpart + '][qty]"]'));
	}
});

$(wrappart).on("click",".remove_part", function(e){
	var modelId = $(this).data('id');
	//user click on remove text
	e.preventDefault();
	//var $row = $(this).parent('.rowmodel');
	var $row = $(this).parent().parent().parent();
	var $option1 = $row.find('[name="srp[' + modelId + '][part_accessory]"]');
	var $option2 = $row.find('[name="srp[' + modelId + '][qty]"]');
	$row.remove();

	$('#form').bootstrapValidator('removeField', $option1);
	$('#form').bootstrapValidator('removeField', $option2);
	console.log(xpart);
	xpart--;
})

/////////////////////////////////////////////////////////////////////////////////////////
// ajax post delete row serial
$(document).on('click', '.delete_serial', function(e){
	var serialId = $(this).data('id');
	SwalDeleteSerial(serialId);
	e.preventDefault();
});

function SwalDeleteSerial(serialId){
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
					url: '{{ url('srSerial') }}' + '/' + serialId,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: serialId,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_product_' + serialId).parent().parent().remove();
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
// ajax post delete row attendees
$(document).on('click', '.delete_attendees', function(e){
	var attendId = $(this).data('id');
	SwalDeleteAttend(attendId);
	e.preventDefault();
});

function SwalDeleteAttend(attendId){
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
					url: '{{ url('srAttend') }}' + '/' + attendId,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: attendId,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_attendees_' + attendId).parent().parent().remove();
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
// ajax post delete row attendees
$(document).on('click', '.delete_model', function(e){
	var modelId = $(this).data('id');
	SwalDeleteModel(modelId);
	e.preventDefault();
});

function SwalDeleteModel(modelId){
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
					url: '{{ url('srModel') }}' + '/' + modelId,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: modelId,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_attendees_' + modelId).parent().parent().remove();
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
// ajax post delete row part & accessories
$(document).on('click', '.delete_part', function(e){
	var partId = $(this).data('id');
	SwalDeletePart(partId);
	e.preventDefault();
});

function SwalDeletePart(partId){
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
					url: '{{ url('srPart') }}' + '/' + partId,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: partId,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_attendees_' + partId).parent().parent().remove();
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
$('#form').bootstrapValidator({
	feedbackIcons: {
		valid: '',
		invalid: '',
		validating: ''
	},
	fields: {
		'date': {
			validators : {
				notEmpty: {
					message: 'Please insert date. '
				},
				date: {
					format: 'YYYY-MM-DD',
					message: 'The value is not a valid date. '
				},
			}
		},
@for($q=1; $q < 501; $q++)
		'srs[{!! $q !!}][serial]': {
			validators : {
				notEmpty: {
					message: 'This value cannot be empty. '
				},
				integer: {
					message: 'The value is not an integer. '
				},
			}
		},
@endfor
		customer_id: {
			validators : {
				notEmpty: {
					message: 'Please choose. '
				},
			}
		},
		charge_id: {
			validators : {
				notEmpty: {
					message: 'Please choose. '
				},
			}
		},
@for ($u=1; $u < 10; $u++)

		'sr[{{ $u }}][attended_by]': {
			validators: {
				notEmpty: {
					message: 'Please choose. '
				},
			}
		},

@endfor
		complaint: {
			validators : {
				notEmpty: {
					message: 'This field cannot be empty. '
				},
			}
		},
		complaint_by: {
			validators : {
				notEmpty: {
					message: 'This field cannot be empty. '
				},
			}
		},
@for ($uu=1; $uu < 10; $uu++)
		'srmo[{!! $uu !!}][model_id]': {
			validators : {
				notEmpty: {
					message: 'Please choose. '
				},
			}
		},
		'srmo[{!! $uu !!}][test_run_machine]': {
			validators : {
				// notEmpty: {
				// 	message: 'This field cannot be empty. '
				// },
			}
		},
		'srmo[{!! $uu !!}][serial_no]': {
			validators : {
				// notEmpty: {
				// 	message: 'This field cannot be empty. '
				// },
			}
		},
		'srmo[{!! $uu !!}][test_capacity]': {
			validators : {
				// notEmpty: {
				// 	message: 'This field cannot be empty. '
				// },
			}
		},
		'srmo[{!! $uu !!}][duration]': {
			validators : {
				// notEmpty: {
				// 	message: 'This field cannot be empty. '
				// },
			}
		},
@endfor
@for($uuu=1; $uuu < 10; $uuu++)
		'srp[{!! $uuu !!}][part_accessory]': {
			validators : {
				notEmpty: {
					message: 'This field cannot be empty. '
				},
			}
		},
		'srp[{!! $uuu !!}][qty]': {
			validators : {
				notEmpty: {
					message: 'This field cannot be empty. '
				},
				integer: {
					message: 'The value is not an integer. '
				},
			}
		},
@endfor
		position_id: {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
			}
		},
	}
})
.find('[name="reason"]')
// .ckeditor()
// .editor
	.on('change', function() {
		// Revalidate the bio field
	$('#form').bootstrapValidator('revalidateField', 'reason');
	// console.log($('#reason').val());
});


/////////////////////////////////////////////////////////////////////////////////////////
@endsection

