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

///////////////////////////////////////////////////////////////////////////////////////////
<?php
$r1 = 1;
$r2 = 1;
$r3 = 1;
$r4 = 1;
$r5 = 1;
$r6 = 1;
$r7 = 1;
$r8 = 1;
$r9 = 1;
$r10 = 1;
$r11 = 1;
$r12 = 1;
$r13 = 1;
$r14 = 1;
$r15 = 1;
$r16 = 1;
?>
@foreach( $serviceReport->hasmanyjob()->get() as $srj )
$('#date_{{ $r1++ }}').datetimepicker({
	format:'YYYY-MM-DD',
	useCurrent: false,
})
.on('dp.change dp.show dp.update', function() {
	$('#form').bootstrapValidator('revalidateField', 'srj[{{ $r2++ }}][date]');
});

$("#wts_{{ $r3++ }}, #wte_{{ $r4++ }}, #ts_1_{{ $r5++ }}, #te_1_{{ $r6++ }}, #ts_2_{{ $r7++ }}, #te_2_{{ $r8++ }}").datetimepicker({
	format: 'h:mm A',
	useCurrent: false,
});

$("#job_perform_{{ $r9++ }}, #ds_1_{{ $r10++ }}, #de_1_{{ $r11++ }}, #ds_2_{{ $r12++ }}, #de_2_{{ $r13++ }}").keyup(function() {
	uch(this);
});

$('#fr_{{ $r14++ }}, #wtv_{{ $r15++ }}, #accommodation_{{ $r16++ }}').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

@endforeach
/////////////////////////////////////////////////////////////////////////////////////////
// add serial : add and remove row

var maxfserial	= 200; //maximum input boxes allowed
var addbtnserial	= $(".add_serial");
var wrapserial	= $(".serial_wrap");

var x = <?=($serviceReport->hasmanyserial()->get()->count() == 0)?0:$serviceReport->hasmanyserial()->get()->count() ?>;
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

var xs = <?= ($serviceReport->hasmanyattendees()->get()->count() == 0)?0:$serviceReport->hasmanyattendees()->get()->count() ?>;
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

var xmod = <?= ($serviceReport->hasmanymodel()->get()->count() == 0)?0:$serviceReport->hasmanymodel()->get()->count() ?>;
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

var xpart = <?= ($serviceReport->hasmanypart()->get()->count() == 0)?0:$serviceReport->hasmanypart()->get()->count() ?>;
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
// ajax post delete row job
$(document).on('click', '.delete_job', function(e){
	var jobId = $(this).data('id');
	SwalDeleteJob(jobId);
	e.preventDefault();
});

function SwalDeleteJob(jobId){
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
					url: '{{ url('srJob') }}' + '/' + jobId,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: jobId,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_attendees_' + jobId).parent().parent().remove();
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

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// counting on service report job
// get all the variable -> start with labour

$(document).on('keyup', '.labour_', function () {
	// food section
	var frate = $(this).parent().parent().parent().children().children().children().children().children().children().children('.fr_');
	var labfrate = $(this).parent().parent().parent().children().children().children().children().children().children().children('.labourfr');
	var tlabf = $(this).parent().parent().parent().children().children().children().children().children().children().children('.tlabourf');

	// $(frate).css({"color": "red", "border": "2px solid red"});
	// $(labfrate).css({"color": "red", "border": "2px solid red"});

	$(labfrate).text( $(this).val() );
	var totallabourfood = ((($(frate).val() * 100)/100) * (( $(this).val() * 100)/100));
	$(tlabf).text( totallabourfood.toFixed(2) );

	// labour section
	var all = $(this).parent().parent().parent().children().children().children().children().children().children().children('.allowanceleaderlabour');
	var anll = $(this).parent().parent().parent().children().children().children().children().children().children().children('.allowancenonleaderlabour');
	var anl = $(this).parent().parent().parent().children().children().children().children().children().children().children('.allowancenonleader');
	var wtv = $(this).parent().parent().parent().children().children().children().children().children().children().children('.workingtypevalue');
	var tla = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totallabourallowance');
	var tla1 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totallabourallowance1');
	var tla2 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totallabourallowance2');

	var countnonleader = $(this).val() - 1;
	$(anl).text( countnonleader );

	if( $(this).val() > 0 ) {
			var totalallowancelabour = ((($(all).val()*100)/100) + ((($(anll).val()*100)/100) * ((countnonleader * 100)/100))) / ( (( $(wtv).val() )*100) /100 );
	} else {
		var totalallowancelabour = 0;
	}
	$(tla).text( totalallowancelabour.toFixed(2) );
	$(tla1).text( totalallowancelabour.toFixed(2) );
	$(tla2).text( totalallowancelabour.toFixed(2) );

	// overtime section
	var oc1 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.overtimeconstant1');
	var oc2 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.overtimeconstant2');
	var oh = $(this).parent().parent().parent().children().children().children().children().children().children().children('.overtimehour');
	var to = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totalovertime');

	var totalovertimee = (((totalallowancelabour * 100)/100) * ((( $(oc1).text() ) * 100 ) /100) * ((( $(oc2).text() ) * 100 ) /100) * (( $(oh).val() * 100) / 100))
	$(to).text(totalovertimee.toFixed(2));

	// travel hour section
	var thc = $(this).parent().parent().parent().children().children().children().children().children().children().children('.travelhourconstant');
	var th = $(this).parent().parent().parent().children().children().children().children().children().children().children('.travelhour');
	var tth = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totaltravelhour');

	var totaltravho = (((totalallowancelabour * 100) / 100) * (($(thc).text() * 100) / 100) * (($(th).val() * 100) / 100));
	$(tth).text(totaltravho.toFixed(2));

	//total per day section
	var ta = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totalaccommodation');
	var tt = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totaltravel');
	var tpdy = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totalperday');
	var tpd = ((totallabourfood * 100) / 100) + ((totalallowancelabour * 100) / 100) + ((totalovertimee * 100) / 100) + (($(ta).text() * 100) / 100) + (($(tt).text() * 100) / 100) + ((totaltravho * 100) / 100);
	$(tpdy).text(tpd.toFixed(2));

	// update grand total
	update_grandtotal();
});

$(document).on('keyup', '.meterstart1', function () {
	var ms11 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.meterstart11');
	var me11 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.meterend11');
	var km1 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.km1');
	var km2 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.km2');
	var tkm = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totalkm');
	var tmr = $(this).parent().parent().parent().children().children().children().children().children().children().children('.travelmeterrate');
	var tt = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totaltravel');
	// $(ms11).css({"color": "red", "border": "2px solid red"});
	$(ms11).text($(this).val());

	var km1new = (($(me11).text() * 100) / 100) - (($(this).val() * 100) / 100);
	$(km1).text(km1new);

	var tkmnew = (($(km2).text() * 100) / 100) + ((km1new * 100) / 100);
	$(tkm).text(tkmnew);

	var ttnew = ((tkmnew * 100) / 100) * (($(tmr).text() * 100) / 100);
	$(tt).text(ttnew.toFixed(2));

	//total per day section
	var tlf = $(this).parent().parent().parent().children().children().children().children().children().children().children('.tlabourf');
	var tla = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totallabourallowance');
	var to = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totalovertime');
	var ta = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totalaccommodation');
	var tth = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totaltravelhour');

	var tpdy = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totalperday');
	var tpd = ( (($(tlf).text() * 100) / 100) + (($(tla).text() * 100) / 100) + (($(to).text() * 100) / 100) + (($(ta).text()* 100) / 100) + ((ttnew * 100) / 100) + (($(tth).text() * 100) / 100) );
	$(tpdy).text(tpd.toFixed(2));

	update_grandtotal();
});

$(document).on('keyup', '.meterend1', function () {
	var ms11 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.meterstart11');
	var me11 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.meterend11');
	var km1 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.km1');
	var km2 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.km2');
	var tkm = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totalkm');
	var tmr = $(this).parent().parent().parent().children().children().children().children().children().children().children('.travelmeterrate');
	var tt = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totaltravel');
	// $(ms11).css({"color": "red", "border": "2px solid red"});
	$(me11).text($(this).val());

	var km1new = (($(this).val() * 100) / 100) - (($(ms11).text() * 100) / 100);
	$(km1).text(km1new);

	var tkmnew = (($(km2).text() * 100) / 100) + ((km1new * 100) / 100);
	$(tkm).text(tkmnew);

	var ttnew = ((tkmnew * 100) / 100) * (($(tmr).text() * 100) / 100);
	$(tt).text(ttnew.toFixed(2));

	//total per day section
	var tlf = $(this).parent().parent().parent().children().children().children().children().children().children().children('.tlabourf');
	var tla = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totallabourallowance');
	var to = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totalovertime');
	var ta = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totalaccommodation');
	var tth = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totaltravelhour');

	var tpdy = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totalperday');
	var tpd = ( (($(tlf).text() * 100) / 100) + (($(tla).text() * 100) / 100) + (($(to).text() * 100) / 100) + (($(ta).text()* 100) / 100) + ((ttnew * 100) / 100) + (($(tth).text() * 100) / 100) );
	$(tpdy).text(tpd.toFixed(2));

	update_grandtotal();
});

$(document).on('keyup', '.meterstart2', function () {
	var ms22 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.meterstart22');
	var me22 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.meterend22');
	var km1 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.km1');
	var km2 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.km2');
	var tkm = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totalkm');
	var tmr = $(this).parent().parent().parent().children().children().children().children().children().children().children('.travelmeterrate');
	var tt = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totaltravel');
	// $(ms11).css({"color": "red", "border": "2px solid red"});
	$(ms22).text($(this).val());

	var km2new = (($(me22).text() * 100) / 100) - (($(this).val() * 100) / 100);
	$(km2).text(km2new);

	var tkmnew = (($(km1).text() * 100) / 100) + ((km2new * 100) / 100);
	$(tkm).text(tkmnew);

	var ttnew = ((tkmnew * 100) / 100) * (($(tmr).text() * 100) / 100);
	$(tt).text(ttnew.toFixed(2));

	//total per day section
	var tlf = $(this).parent().parent().parent().children().children().children().children().children().children().children('.tlabourf');
	var tla = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totallabourallowance');
	var to = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totalovertime');
	var ta = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totalaccommodation');
	var tth = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totaltravelhour');

	var tpdy = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totalperday');
	var tpd = ( (($(tlf).text() * 100) / 100) + (($(tla).text() * 100) / 100) + (($(to).text() * 100) / 100) + (($(ta).text()* 100) / 100) + ((ttnew * 100) / 100) + (($(tth).text() * 100) / 100) );
	$(tpdy).text(tpd.toFixed(2));

	update_grandtotal();
});

$(document).on('keyup', '.meterend2', function () {
	var ms22 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.meterstart22');
	var me22 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.meterend22');
	var km1 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.km1');
	var km2 = $(this).parent().parent().parent().children().children().children().children().children().children().children('.km2');
	var tkm = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totalkm');
	var tmr = $(this).parent().parent().parent().children().children().children().children().children().children().children('.travelmeterrate');
	var tt = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totaltravel');
	// $(ms11).css({"color": "red", "border": "2px solid red"});
	$(me22).text($(this).val());

	var km2new = (($(this).val() * 100) / 100) - (($(ms22).text() * 100) / 100);
	$(km2).text(km2new);

	var tkmnew = (($(km1).text() * 100) / 100) + ((km2new * 100) / 100);
	$(tkm).text(tkmnew);

	var ttnew = ((tkmnew * 100) / 100) * (($(tmr).text() * 100) / 100);
	$(tt).text(ttnew.toFixed(2));

	//total per day section
	var tlf = $(this).parent().parent().parent().children().children().children().children().children().children().children('.tlabourf');
	var tla = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totallabourallowance');
	var to = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totalovertime');
	var ta = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totalaccommodation');
	var tth = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totaltravelhour');

	var tpdy = $(this).parent().parent().parent().children().children().children().children().children().children().children('.totalperday');
	var tpd = ( (($(tlf).text() * 100) / 100) + (($(tla).text() * 100) / 100) + (($(to).text() * 100) / 100) + (($(ta).text()* 100) / 100) + ((ttnew * 100) / 100) + (($(tth).text() * 100) / 100) );
	$(tpdy).text(tpd.toFixed(2));

	update_grandtotal();
});

$(document).on('change', '.fr_', function () {
	var lfr = $(this).parent().parent().parent().children().children().children('.labourfr');
	var tlf = $(this).parent().parent().parent().children().children().children('.tlabourf');
	// $(lfr).css({"color": "red", "border": "2px solid red"});
	// $(tlf).css({"color": "red", "border": "2px solid red"});
	// console.log($(this).val());

	var tlfnew = (($(this).val() * 100) / 100) * (($(lfr).text() * 100) / 100);
	$(tlf).text(tlfnew.toFixed(2));

	//total per day section
	// var tlf = $(this).parent().parent().parent().children().children().children('.labourfr');
	var tla = $(this).parent().parent().parent().children().children().children('.totallabourallowance');
	var to = $(this).parent().parent().parent().children().children().children('.totalovertime');
	var ta = $(this).parent().parent().parent().children().children().children('.totalaccommodation');
	var tt = $(this).parent().parent().parent().children().children().children('.totaltravel');
	var tth = $(this).parent().parent().parent().children().children().children('.totaltravelhour');

	var tpdy = $(this).parent().parent().parent().parent().children().children().children().children('.totalperday');
	// $(tpdy).css({"color": "red", "border": "2px solid red"});

	var tpd = ( ((tlfnew * 100) / 100) + (($(tla).text() * 100) / 100) + (($(to).text() * 100) / 100) + (($(ta).text()* 100) / 100) + (($(tt).text() * 100) / 100) + (($(tth).text() * 100) / 100) );
	$(tpdy).text(tpd.toFixed(2));

	update_grandtotal();
});

$(document).on('keyup', '.allowanceleaderlabour', function () {
	var anll = $(this).parent().parent().parent().children().children().children('.allowancenonleaderlabour');
	var anl = $(this).parent().parent().parent().children().children().children('.allowancenonleader');
	var wtv = $(this).parent().parent().parent().children().children().children('.workingtypevalue');
	var tla = $(this).parent().parent().parent().children().children().children('.totallabourallowance');

	// $(anll).css({"color": "red", "border": "2px solid red"});
	// console.log($(this).val());

	var tlanew = ( (($(this).val() * 100) / 100) + ((($(anll).val() * 100) / 100) * (($(anl).text() * 100) / 100)) ) / (($(wtv).val() * 100) / 100);
	$(tla).text(tlanew.toFixed(2));

	//total per day section
	var tlf = $(this).parent().parent().parent().children().children().children('.tlabourf');
	// var tla = $(this).parent().parent().parent().children().children().children('.totallabourallowance');
	var to = $(this).parent().parent().parent().children().children().children('.totalovertime');
	var ta = $(this).parent().parent().parent().children().children().children('.totalaccommodation');
	var tt = $(this).parent().parent().parent().children().children().children('.totaltravel');
	var tth = $(this).parent().parent().parent().children().children().children('.totaltravelhour');

	var tpdy = $(this).parent().parent().parent().parent().children().children().children().children('.totalperday');
	// $(tpdy).css({"color": "red", "border": "2px solid red"});

	var tpd = ( (($(tlf).text() * 100) / 100) + ((tlanew * 100) / 100) + (($(to).text() * 100) / 100) + (($(ta).text()* 100) / 100) + (($(tt).text() * 100) / 100) + (($(tth).text() * 100) / 100) );
	$(tpdy).text(tpd.toFixed(2));

	update_grandtotal();
});

$(document).on('keyup', '.allowancenonleaderlabour', function () {
	var all = $(this).parent().parent().parent().children().children().children('.allowanceleaderlabour');
	var anl = $(this).parent().parent().parent().children().children().children('.allowancenonleader');
	var wtv = $(this).parent().parent().parent().children().children().children('.workingtypevalue');
	var tla = $(this).parent().parent().parent().children().children().children('.totallabourallowance');

	// $(anll).css({"color": "red", "border": "2px solid red"});
	// console.log($(this).val());

	var tlanew = ( (($(all).val() * 100) / 100) + ((($(this).val() * 100) / 100) * (($(anl).text() * 100) / 100)) ) / (($(wtv).val() * 100) / 100);
	$(tla).text(tlanew.toFixed(2));

	//total per day section
	var tlf = $(this).parent().parent().parent().children().children().children('.tlabourf');
	// var tla = $(this).parent().parent().parent().children().children().children('.totallabourallowance');
	var to = $(this).parent().parent().parent().children().children().children('.totalovertime');
	var ta = $(this).parent().parent().parent().children().children().children('.totalaccommodation');
	var tt = $(this).parent().parent().parent().children().children().children('.totaltravel');
	var tth = $(this).parent().parent().parent().children().children().children('.totaltravelhour');

	var tpdy = $(this).parent().parent().parent().parent().children().children().children().children('.totalperday');
	// $(tpdy).css({"color": "red", "border": "2px solid red"});

	var tpd = ( (($(tlf).text() * 100) / 100) + ((tlanew * 100) / 100) + (($(to).text() * 100) / 100) + (($(ta).text()* 100) / 100) + (($(tt).text() * 100) / 100) + (($(tth).text() * 100) / 100) );
	$(tpdy).text(tpd.toFixed(2));

	update_grandtotal();
});

$(document).on('change', '.workingtypevalue', function () {
	var all = $(this).parent().parent().parent().children().children().children('.allowanceleaderlabour');
	var anl = $(this).parent().parent().parent().children().children().children('.allowancenonleader');
	var anll = $(this).parent().parent().parent().children().children().children('.allowancenonleaderlabour');
	var tla = $(this).parent().parent().parent().children().children().children('.totallabourallowance');

	// $(anll).css({"color": "red", "border": "2px solid red"});
	// console.log($(this).val());

	var tlanew = ( (($(all).val() * 100) / 100) + ((($(anll).val() * 100) / 100) * (($(anl).text() * 100) / 100)) ) / (($(this).val() * 100) / 100);
	$(tla).text(tlanew.toFixed(2));

	//total per day section
	var tlf = $(this).parent().parent().parent().children().children().children('.tlabourf');
	// var tla = $(this).parent().parent().parent().children().children().children('.totallabourallowance');
	var to = $(this).parent().parent().parent().children().children().children('.totalovertime');
	var ta = $(this).parent().parent().parent().children().children().children('.totalaccommodation');
	var tt = $(this).parent().parent().parent().children().children().children('.totaltravel');
	var tth = $(this).parent().parent().parent().children().children().children('.totaltravelhour');

	var tpdy = $(this).parent().parent().parent().parent().children().children().children().children('.totalperday');
	// $(tpdy).css({"color": "red", "border": "2px solid red"});

	var tpd = ( (($(tlf).text() * 100) / 100) + ((tlanew * 100) / 100) + (($(to).text() * 100) / 100) + (($(ta).text()* 100) / 100) + (($(tt).text() * 100) / 100) + (($(tth).text() * 100) / 100) );
	$(tpdy).text(tpd.toFixed(2));

	update_grandtotal();
});

$(document).on('keyup', '.overtimehour', function () {
	var tla1 = $(this).parent().parent().parent().children().children().children('.totallabourallowance1');
	var oc1 = $(this).parent().parent().parent().children().children().children('.overtimeconstant1');
	var oc2 = $(this).parent().parent().parent().children().children().children('.overtimeconstant2');
	var to = $(this).parent().parent().parent().children().children().children('.totalovertime');

	var tonew = (($(tla1).text() * 100) / 100) * (($(oc1).text() * 100) / 100) * (($(oc2).text() * 100) / 100) * (($(this).val() * 100) / 100);
	$(to).text(tonew.toFixed(2));

	//total per day section
	var tlf = $(this).parent().parent().parent().children().children().children('.tlabourf');
	var tla = $(this).parent().parent().parent().children().children().children('.totallabourallowance');
	// var to = $(this).parent().parent().parent().children().children().children('.totalovertime');
	var ta = $(this).parent().parent().parent().children().children().children('.totalaccommodation');
	var tt = $(this).parent().parent().parent().children().children().children('.totaltravel');
	var tth = $(this).parent().parent().parent().children().children().children('.totaltravelhour');

	var tpdy = $(this).parent().parent().parent().parent().children().children().children().children('.totalperday');
	// $(tpdy).css({"color": "red", "border": "2px solid red"});

	var tpd = ( (($(tlf).text() * 100) / 100) + (($(tla).text() * 100) / 100) + ((tonew * 100) / 100) + (($(ta).text()* 100) / 100) + (($(tt).text() * 100) / 100) + (($(tth).text() * 100) / 100) );
	$(tpdy).text(tpd.toFixed(2));

	update_grandtotal();
});

$(document).on('keyup', '.accommodationrate', function () {
	// var ar = $(this).parent().parent().parent().children().children().children('.accommodationrate');
	var ac = $(this).parent().parent().parent().children().children().children('.accommodation');
	var ta = $(this).parent().parent().parent().children().children().children('.totalaccommodation');

	var tanew = (($(this).val() * 100) / 100) * (($(ac).val() * 100) / 100);
	$(ta).text(tanew.toFixed(2));

	//total per day section
	var tlf = $(this).parent().parent().parent().children().children().children('.tlabourf');
	var tla = $(this).parent().parent().parent().children().children().children('.totallabourallowance');
	var to = $(this).parent().parent().parent().children().children().children('.totalovertime');
	// var ta = $(this).parent().parent().parent().children().children().children('.totalaccommodation');
	var tt = $(this).parent().parent().parent().children().children().children('.totaltravel');
	var tth = $(this).parent().parent().parent().children().children().children('.totaltravelhour');

	var tpdy = $(this).parent().parent().parent().parent().children().children().children().children('.totalperday');
	// $(tpdy).css({"color": "red", "border": "2px solid red"});

	var tpd = ( (($(tlf).text() * 100) / 100) + (($(tla).text() * 100) / 100) + (($(to).text() * 100) / 100) + ((tanew * 100) / 100) + (($(tt).text() * 100) / 100) + (($(tth).text() * 100) / 100) );
	$(tpdy).text(tpd.toFixed(2));

	update_grandtotal();
});

$(document).on('change', '.accommodation', function () {				// 
	var ar = $(this).parent().parent().parent().children().children().children('.accommodationrate');
	// var ac = $(this).parent().parent().parent().children().children().children('.accommodation');
	var ta = $(this).parent().parent().parent().children().children().children('.totalaccommodation');

	var tanew = (($(ar).val() * 100) / 100) * (($(this).val() * 100) / 100);
	$(ta).text(tanew.toFixed(2));

	//total per day section
	var tlf = $(this).parent().parent().parent().children().children().children('.tlabourf');
	var tla = $(this).parent().parent().parent().children().children().children('.totallabourallowance');
	var to = $(this).parent().parent().parent().children().children().children('.totalovertime');
	// var ta = $(this).parent().parent().parent().children().children().children('.totalaccommodation');
	var tt = $(this).parent().parent().parent().children().children().children('.totaltravel');
	var tth = $(this).parent().parent().parent().children().children().children('.totaltravelhour');

	var tpdy = $(this).parent().parent().parent().parent().children().children().children().children('.totalperday');
	// $(tpdy).css({"color": "red", "border": "2px solid red"});

	var tpd = ( (($(tlf).text() * 100) / 100) + (($(tla).text() * 100) / 100) + (($(to).text() * 100) / 100) + ((tanew * 100) / 100) + (($(tt).text() * 100) / 100) + (($(tth).text() * 100) / 100) );
	$(tpdy).text(tpd.toFixed(2));

	update_grandtotal();
});

$(document).on('keyup', '.travelhour', function () {
	var tla2 = $(this).parent().parent().parent().children().children().children('.totallabourallowance2');
	var thc = $(this).parent().parent().parent().children().children().children('.travelhourconstant');
	var tth = $(this).parent().parent().parent().children().children().children('.totaltravelhour');

	var tthnew = (($(tla2).text() * 100) / 100) * (($(thc).text() * 100) / 100) * (($(this).val() * 100) / 100);
	$(tth).text(tthnew.toFixed(2));

	//total per day section
	var tlf = $(this).parent().parent().parent().children().children().children('.tlabourf');
	var tla = $(this).parent().parent().parent().children().children().children('.totallabourallowance');
	var to = $(this).parent().parent().parent().children().children().children('.totalovertime');
	var ta = $(this).parent().parent().parent().children().children().children('.totalaccommodation');
	var tt = $(this).parent().parent().parent().children().children().children('.totaltravel');
	// var tth = $(this).parent().parent().parent().children().children().children('.totaltravelhour');

	var tpdy = $(this).parent().parent().parent().parent().children().children().children().children('.totalperday');
	// $(tpdy).css({"color": "red", "border": "2px solid red"});

	var tpd = ( (($(tlf).text() * 100) / 100) + (($(tla).text() * 100) / 100) + (($(to).text() * 100) / 100) + (($(ta).text() * 100) / 100) + (($(tt).text() * 100) / 100) + ((tthnew * 100) / 100) );
	$(tpdy).text(tpd.toFixed(2));

	update_grandtotal();
});

// update grand total
function update_grandtotal() {
	var myNodelistp = $(".totalperday");
	var psum = 0;
	for (var ip = myNodelistp.length - 1; ip >= 0; ip--) {
		// myNodelistp[ip].style.backgroundColor = "red";

		psum = ( (psum * 10000) + (myNodelistp[ip].innerHTML * 10000) ) / 10000;

		// console.log(myNodelistp[ip].innerHTML);
		// console.log(psum);
	}
	$('#grandtotal').text( psum.toFixed(2) );
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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

@for($xc = 1; $xc < 2000; $xc++)
		'srj[{{ $xc }}][date]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
			}
		},
		'srj[{{ $xc }}][labour]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
				integer: {
					message: 'The value is not an integer. '
				},
			}
		},
@endfor
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

