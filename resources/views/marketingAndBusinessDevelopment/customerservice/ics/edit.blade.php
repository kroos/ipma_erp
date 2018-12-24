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
$("#compby, #compl, #remarks").keyup(function() {
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


///////////////////////////////////////////////////////////////////////////////////////////
// attendees
<?php $attend = 1 ?>
@foreach($serviceReport->hasmanyattendees()->get() as $ftg)
$('#staff_id_{!! $attend++ !!}').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});
@endforeach

///////////////////////////////////////////////////////////////////////////////////////////
// model
@for ($iiiiii = ($serviceReport->hasmanymodel()->get()->count() > 0)?$serviceReport->hasmanymodel()->get()->count():1; $iiiiii <= $serviceReport->hasmanymodel()->get()->count() + 1; $iiiiii++)
$('#model_{!! $iiiiii !!}').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

$("#test_run_machine_{{ $iiiiii }} , #serial_no_{{ $iiiiii }}, #test_capacity_{{ $iiiiii }}, #duration_{{ $iiiiii }}").keyup(function() {
	tch(this);
});
@endfor

///////////////////////////////////////////////////////////////////////////////////////////
// logistic
@for ($srlo = ($serviceReport->hasmanylogistic()->get()->count() > 0)?$serviceReport->hasmanylogistic()->get()->count():1; $srlo <= $serviceReport->hasmanylogistic()->get()->count() + 1; $srlo++)
$('#vc_{!! $srlo !!}, #v_{{ $srlo }}').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

$('#v_{{ $srlo }}').chainedTo('#vc_{{ $srlo }}');

$("#description_{{ $srlo }}").keyup(function() {
	tch(this);
});
@endfor

///////////////////////////////////////////////////////////////////////////////////////////
<?php
$t = 1;
?>
@foreach($serviceReport->hasmanypart()->get() as $srp)
$("#part_accessory_{{ $t++ }}").keyup(function() {
	tch(this);
});
@endforeach

///////////////////////////////////////////////////////////////////////////////////////////
// additional charges
<?php
$addc1 = 1;
$addc2 = 1;
?>
@foreach($serviceReport->hasmanyadditionalcharge()->get() as $sraddc)
$('#aid_{!! $addc1++ !!}').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

$("#description_amount_{{ $addc2++ }}").keyup(function() {
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
// problem solution
@for ($pf1 = ($serviceReport->hasmanyfeedproblem()->get()->count() > 0)?$serviceReport->hasmanyfeedproblem()->get()->count():1; $pf1 <= $serviceReport->hasmanyfeedproblem()->get()->count() + 1; $pf1++)
$("#problem_{{ $pf1 }}, #solution_{{ $pf1 }}").keyup(function() {
	tch(this);
});
@endfor

/////////////////////////////////////////////////////////////////////////////////////////
// request action
@for ($pfr2 = ($serviceReport->hasmanyfeedrequest()->get()->count() > 0)?$serviceReport->hasmanyfeedrequest()->get()->count():1; $pfr2 <= $serviceReport->hasmanyfeedrequest()->get()->count() + 1; $pfr2++)
$("#request_{{ $pfr2 }}, #action_{{ $pfr2 }}").keyup(function() {
	tch(this);
});
@endfor

/////////////////////////////////////////////////////////////////////////////////////////
// item item_action
@for ($pfr3 = ($serviceReport->hasmanyfeeditem()->get()->count() > 0)?$serviceReport->hasmanyfeeditem()->get()->count():1; $pfr3 <= $serviceReport->hasmanyfeeditem()->get()->count() + 1; $pfr3++)
$("#item_{{ $pfr3 }}, #item_action_{{ $pfr3 }}").keyup(function() {
	tch(this);
});
@endfor

/////////////////////////////////////////////////////////////////////////////////////////
// discount
<?php $srdi = 1 ?>
@foreach( $serviceReport->hasonediscount()->get() as $srDic )
$('#srdisc_{{ $srdi++ }}').select2({
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
						'<div class="col-sm-12 form-row ">' +
							'<div class="col-sm-1 text-danger">' +
									'<i class="fas fa-trash remove_model" aria-hidden="true" id="delete_model_' + xmod + '" data-id="' + xmod + '"></i>' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srmo.*.model_id') ? 'has-error' : '' }}">' +
								'<select name="srmo[' + xmod + '][model_id]" id="model_' + xmod + '" class="form-control form-control-sm" autocomplete="off" placeholder="Please choose">' +
									'<option value="">Please choose</option>' +
@foreach( $model as $mod )
									'<option value="{!! $mod->id !!}">{!! $mod->model !!}</option>' +
@endforeach
								'</select>' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srmo.*.test_run_machine') ? 'has-error' : '' }}">' +
								'<input type="text" name="srmo[' + xmod + '][test_run_machine]" id="test_run_machine_' + xmod + '" class="form-control form-control-sm" autocomplete="off" placeholder="Test Run Machine" />' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srmo.*.serial_no') ? 'has-error' : '' }}">' +
								'<input type="text" name="srmo[' + xmod + '][serial_no]" id="serial_no_' + xmod + '" class="form-control form-control-sm" autocomplete="off" placeholder="Serial No" />' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srmo.*.test_capacity') ? 'has-error' : '' }}">' +
								'<input type="text" name="srmo[' + xmod + '][test_capacity]" id="test_capacity_' + xmod + '" class="form-control form-control-sm" autocomplete="off" placeholder="Test Capacity" />' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srmo.*.duration') ? 'has-error' : '' }}">' +
								'<input type="text" name="srmo[' + xmod + '][duration]" id="duration_' + xmod + '" class="form-control form-control-sm" autocomplete="off" placeholder="Duration" />' +
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
						'<div class="col-sm-12 form-row ">' +
							'<div class="col-sm-1 text-danger">' +
									'<i class="fas fa-trash remove_part" aria-hidden="true" id="delete_part_' + xpart + '" data-id="' + xpart + '"></i>' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srp.*.part_accessory') ? 'has-error' : '' }}">' +
								'<input type="text" name="srp[' + xpart + '][part_accessory]" value="{!! (!empty($srp->part_accessory))?$srp->part_accessory:@$value !!}" id="part_accessory_' + xpart + '" class="form-control" autocomplete="off" placeholder="Parts & Accessories" />' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srp.*.qty') ? 'has-error' : '' }}">' +
								'<input type="text" name="srp[' + xpart + '][qty]" value="{!! (!empty($srp->qty))?$srp->qty:@$value !!}" id="qty_' + xpart + '" class="form-control" autocomplete="off" placeholder="Quantity" />' +
							'</div>' +
						'</div>' +
					'</div>'
		); //add input box

		$('#part_accessory_' + xpart).keyup(function() {
			tch(this);
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField',	$('.rowpart')	.find('[name="srp[' + xpart + '][part_accessory]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowpart')	.find('[name="srp[' + xpart + '][qty]"]'));
	}
});

$(wrappart).on("click",".remove_part", function(e){
	var modelId = $(this).data('id');
	//user click on remove text
	e.preventDefault();
	//var $row = $(this).parent('.rowpart');
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
// add Job & Job Details : add and remove row
var maxfjobnd	= 2000; //maximum input boxes allowed
var addbtnjobn	= $(".add_job");
var wrapjobnd	= $(".job_wrap");

var xj = <?= ($serviceReport->hasmanyjob()->get()->count() == 0)?0:$serviceReport->hasmanyjob()->get()->count() ?>;
$(addbtnjobn).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(xj < maxfjobnd){
		xj++;
		wrapjobnd.append(
					'<div class="rowjob">' +
						'<div class="form-row col-sm-12">' +
							'<div class="col-sm-1 text-danger">' +
								'<i class="fas fa-trash remove_job" aria-hidden="true" id="remove_job_' + xj + '" data-id="' + xj + '"></i>' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srj.*.date') ? 'has-error' : '' }}">' +
								'<input type="text" name="srj[' + xj + '][date]" value="{!! @$value !!}" id="date_' + xj + '" class="form-control form-control-sm" autocomplete="off" placeholder="Date" />' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srj.*.labour') ? 'has-error' : '' }}">' +
								'<input type="text" name="srj[' + xj + '][labour]" value="{!! @$value !!}" id="labour_' + xj + '" class="form-control form-control-sm labour_" autocomplete="off" placeholder="Labour Count" />' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srj.*.job_perform') ? 'has-error' : '' }}">' +
								'<textarea name="srj[' + xj + '][job_perform]" value="{!! @$value !!}" id="job_perform_' + xj + '" class="form-control form-control-sm" autocomplete="off" placeholder="Job Perform" /></textarea>' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srj.*.working_time_start') ? 'has-error' : '' }}">' +
								'<input type="text" name="srj[' + xj + '][working_time_start]" value="{!! @$value !!}" id="wts_' + xj + '" class="form-control form-control-sm" autocomplete="off" placeholder="Working Time Start" />' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srj.*.working_time_end') ? 'has-error' : '' }}">' +
								'<input type="text" name="srj[' + xj + '][working_time_end]" value="{!! @$value !!}" id="wte_' + xj + '" class="form-control form-control-sm" autocomplete="off" placeholder="Working Time End" />' +
							'</div>' +
						'</div>' +
						'<br />' +
						'<div class="col-sm-12 form-row ">' +
							'<div class="col-sm-1 text-primary"><small>To <i class="fas fa-arrow-right"></i> <i class="fas fa-map-marker-alt"></i></small></div>' +
							'<div class="form-group {{ $errors->has('srj.*.*.date') ? 'has-error' : '' }}">' +
								'<input type="text" name="srj[' + xj + '][srjde][1][destination_start]" value="{!! @$value !!}" id="ds_1_' + xj + '" class="form-control form-control-sm" autocomplete="off" placeholder="Destination Start" />' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srj.*.*.destination_end') ? 'has-error' : '' }}">' +
								'<input type="text" name="srj[' + xj + '][srjde][1][destination_end]" value="{!! @$value !!}" id="de_1_' + xj + '" class="form-control form-control-sm" autocomplete="off" placeholder="Destination End" />' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srj.*.*.meter_start') ? 'has-error' : '' }}">' +
								'<input type="textarea" name="srj[' + xj + '][srjde][1][meter_start]" value="{!! @$value !!}" id="ms_1_' + xj + '" class="form-control form-control-sm meterstart1" autocomplete="off" placeholder="Meter Start" />' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srj.*.*.meter_end') ? 'has-error' : '' }}">' +
								'<input type="text" name="srj[' + xj + '][srjde][1][meter_end]" value="{!! @$value !!}" id="me_1_' + xj + '" class="form-control form-control-sm meterend1" autocomplete="off" placeholder="Meter End" />' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srj.*.*.time_start') ? 'has-error' : '' }}">' +
								'<input type="text" name="srj[' + xj + '][srjde][1][time_start]" value="{!! @$value !!}" id="ts_1_' + xj + '" class="form-control form-control-sm" autocomplete="off" placeholder="Travel Time Start" />' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srj.*.*.time_end') ? 'has-error' : '' }}">' +
								'<input type="text" name="srj[' + xj + '][srjde][1][time_end]" value="{!! @$value !!}" id="te_1_' + xj + '" class="form-control form-control-sm" autocomplete="off" placeholder="Travel Time End" />' +
							'</div>' +
							'<input type="hidden" name="srj[' + xj + '][srjde][1][return]" value="0">' +
						'</div>' +
						'<div class="col-sm-12 form-row ">' +
							'<div class="col-sm-1 text-primary"><small>Return <i class="fas fa-map-marker-alt"></i> <i class="fas fa-undo"></i></small></div>' +
							'<div class="form-group {{ $errors->has('srjd.*.date') ? 'has-error' : '' }}">' +
								'<input type="text" name="srj[' + xj + '][srjde][2][destination_start]" value="{!! @$value !!}" id="ds_2_' + xj + '" class="form-control form-control-sm" autocomplete="off" placeholder="Destination Start" />' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srjd.*.destination_end') ? 'has-error' : '' }}">' +
								'<input type="text" name="srj[' + xj + '][srjde][2][destination_end]" value="{!! @$value !!}" id="de_2_' + xj + '" class="form-control form-control-sm" autocomplete="off" placeholder="Destination End" />' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srjd.*.meter_start') ? 'has-error' : '' }}">' +
								'<input type="textarea" name="srj[' + xj + '][srjde][2][meter_start]" value="{!! @$value !!}" id="ms_2_' + xj + '" class="form-control form-control-sm meterstart2" autocomplete="off" placeholder="Meter Start" />' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srjd.*.meter_end') ? 'has-error' : '' }}">' +
								'<input type="text" name="srj[' + xj + '][srjde][2][meter_end]" value="{!! @$value !!}" id="me_2_' + xj + '" class="form-control form-control-sm meterend2" autocomplete="off" placeholder="Meter End" />' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srjd.*.time_start') ? 'has-error' : '' }}">' +
								'<input type="text" name="srj[' + xj + '][srjde][2][time_start]" value="{!! @$value !!}" id="ts_2_' + xj + '" class="form-control form-control-sm" autocomplete="off" placeholder="Travel Time Start" />' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srjd.*.time_end') ? 'has-error' : '' }}">' +
								'<input type="text" name="srj[' + xj + '][srjde][2][time_end]" value="{!! @$value !!}" id="te_2_' + xj + '" class="form-control form-control-sm" autocomplete="off" placeholder="Travel Time End" />' +
							'</div>' +
							'<input type="hidden" name="srj[' + xj + '][srjde][2][return]" value="1">' +
						'</div>' +
						'<br />' +
'<!-- inserting FLOAT TH -->' +
						'<div class="col-sm-12">' +
						'<!-- <div class="col-sm-12 border border-primary"> -->' +
							'<small>' +
								'<!-- insert food -->' +
								'<table class="table table-hover" style="font-size:12px">' +
									'<tbody>' +
										'<tr>' +
											'<td>Food : </td>' +
											'<td class="form-group {{ $errors->has('srj.*.food_rate') ? ' has-error' : '' }}">' +
												'<select name="srj[' + xj + '][food_rate]" id="fr_' + xj + '" class="form-control form-control-sm fr_" placeholder="Please choose">' +
													'<option value="">Please choose</option>' +
@foreach( \App\Model\ICSFoodRate::all() as $fr )
													'<option value="{!! $fr->value !!}" data-value="{{ $fr->value }}">{!! $fr->food_rate !!}</option>' +
@endforeach
												'</select>' +
											'</td>' +
											'<td>X</td>' +
											'<td><span class="labourfr" id="lab_' + xj + '">0</span> Person</td>' +
											'<td colspan="6">&nbsp;</td>' +
											'<td>=</td>' +
											'<td class="font-weight-bold">RM <span class="tlabourf" id="total_food_' + xj + '">0.00</span></td>' +
										'</tr>' +
										'<tr>' +
											'<td>Labour :</td>' +
											'<td class="form-group {{ $errors->has('srj.*.labour_leader') ? ' has-error' : '' }}">' +
												'<input type="text" name="srj[' + xj + '][labour_leader]" value="150.00" class="form-control form-control-sm allowanceleaderlabour" id="leadership_' + xj + '" placeholder="Leader Rate (MYR)">' +
											'</td>' +
											'<td>+</td>' +
											'<td>(</td>' +
											'<td class="form-group {{ $errors->has('srj.*.labour_non_leader') ? ' has-error' : '' }}">' +
												'<input type="text" name="srj[' + xj + '][labour_non_leader]" value="100.00" class="form-control form-control-sm allowancenonleaderlabour" id="non_leadership_' + xj + '" placeholder="Non Leader Rate (RM)">' +
											'</td>' +
											'<td>X</td>' +
											'<td><span class="allowancenonleader" id="non_leader_count_' + xj + '">0</span> Person</td>' +
											'<td>)</td>' +
											'<td>/</td>' +
											'<td class="form-group {{ $errors->has('srj.*.working_type_value') ? ' has-error' : '' }}">' +
												'<select name="srj[' + xj + '][working_type_value]" id="wtv_' + xj + '" class="form-control form-control-sm workingtypevalue">' +
													'<option value="">Please choose</option>' +
@foreach( \App\Model\ICSWorkingType::all() as $wt )
													'<option value="{!! $wt->value !!}" data-value="{!! $wt->value !!}">{!! $wt->working_type !!}</option>' +
@endforeach
												'</select>' +
											'</td>' +
											'<td>=</td>' +
											'<td class="font-weight-bold">' +
												'RM <span class="totallabourallowance" id="total_labour_' + xj + '">0.00</span>' +
											'</td>' +
										'</tr>' +
										'<tr>' +
											'<td>Overtime :</td>' +
											'<td>' +
												'RM <span class="totallabourallowance1" id="total_labour_' + xj + '">0.00</span>' +
											'</td>' +
											'<td>X</td>' +
											'<td><span class="overtimeconstant1">{{ \App\Model\ICSFloatthConstant::where('active', 1)->first()->overtime_constant_1 }}</span> X <span class="overtimeconstant2">{{ \App\Model\ICSFloatthConstant::where('active', 1)->first()->overtime_constant_2 }}</span></td>' +
											'<td>X</td>' +
											'<td class="form-group {{ $errors->has('srj.*.overtime_hour') ? ' has-error' : '' }}">' +
												'<input type="text" name="srj[' + xj + '][overtime_hour]" value="{{ @$value }}" class="form-control form-control-sm overtimehour" id="overtime_hour_' + xj + '" placeholder="Hour">' +
											'</td>' +
											'<td>hour</td>' +
											'<td colspan="3">&nbsp;</td>' +
											'<td>=</td>' +
											'<td class="font-weight-bold">' +
												'RM <span class="totalovertime" id="total_overtime_' + xj + '">0.00</span>' +
											'</td>' +
										'</tr>' +
										'<tr>' +
											'<td>Accommodation :</td>' +
											'<td class="form-group {{ $errors->has('srj.*.accommodation_rate') ? ' has-error' : '' }}">' +
												'<input type="text" name="srj[' + xj + '][accommodation_rate]" value="<?php echo \App\Model\ICSFloatthConstant::where('active', 1)->first()->accomodation_rate ?>" class="form-control form-control-sm accommodationrate" id="accommodation_rate_' + xj + '" placeholder="Accommodation Rate (RM)">' +
											'</td>' +
											'<td>X</td>' +
											'<td>' +
												'<select name="srj[' + xj + '][accommodation]" id="accommodation_' + xj + '" class="form-control form-control-sm accommodation" placeholder="Please choose">' +
													'<option value="">Please choose</option>' +
@foreach( \App\Model\ICSAccommodationRate::all() as $acr )
													'<option value="{!! $acr->value !!}" data-value="{!! $acr->value !!}">{!! $acr->accommodation_rate !!}</option>' +
@endforeach
												'</select>' +
											'</td>' +
											'<td colspan="6">&nbsp;</td>' +
											'<td>=</td>' +
											'<td class="font-weight-bold">RM <span class="totalaccommodation" id="total_accommodation_' + xj + '">0.00</span></td>' +
										'</tr>' +
										'<tr>' +
											'<td>Travel :</td>' +
											'<td colspan="2">' +
												'Meter Calculator:<br />' +
												'Trip : <span class="meterend11" id="ms_1_' + xj + '">0</span> - <span class="meterstart11" id="me_1_' + xj + '">0</span> = <span class="km1" id="total_go_1_' + xj + '">0</span> KM<br />' +
												'Return : <span class="meterend22" id="ms_2_' + xj + '">0</span> - <span class="meterstart22" id="me_2_' + xj + '">0</span> = <span class="km2" id="total_go_2_' + xj + '">0</span> KM<br />' +
												'Total = <span class="totalkm" id="total_km_1_' + xj + '">0</span> KM' +
											'</td>' +
											'<td>X</td>' +
											'<td><span class="travelmeterrate" id="tmr_' + xj + '">{!! \App\Model\ICSFloatthConstant::where('active', 1)->first()->travel_meter_rate !!}</span></td>' +
											'<td colspan="5"></td>' +
											'<td>=</td>' +
											'<td class="font-weight-bold">' +
												'RM <span class="totaltravel" id="total_meter_' + xj + '">0.00</span>' +
											'</td>' +
										'</tr>' +
										'<tr>' +
											'<td>Travel Hour :</td>' +
											'<td>RM' +
												 '<span class="totallabourallowance2" id="total_labour_th_' + xj + '">0.00</span>' +
											'</td>' +
											'<td>X</td>' +
											'<td>' +
												'<span class="travelhourconstant" id="th_constant_' + xj + '">{{ \App\Model\ICSFloatthConstant::where('active', 1)->first()->travel_hour_rate }}</span>' +
											'</td>' +
											'<td>X</td>' +
											'<td class="form-group {{ $errors->has('srj.*.travel_hour') ? ' has-error' : '' }}">' +
												'<input type="text" name="srj[' + xj + '][travel_hour]" value="{!! @$value !!}" id="travel_hour_' + xj + '" class="form-control form-control-sm travelhour" placeholder="Travel Hour">' +
											'</td>' +
											'<td>hour</td>' +
											'<td colspan="3">&nbsp;</td>' +
											'<td>=</td>' +
											'<td class="font-weight-bold">RM ' +
												'<span class="totaltravelhour" id="total_th_' + xj + '">0.00</span>' +
											'</td>' +
										'</tr>' +
									'</tbody>' +
									'<tfoot>' +
										'<tr>' +
											'<td colspan="10">Total Per Day :</td>' +
											'<td>=</td>' +
											'<td>RM ' +
												'<span class="text-primary font-weight-bold totalperday" id="total_per_day_' + xj + '">0.00</span>' +
											'</td>' +
										'</tr>' +
									'</tfoot>' +
								'</table>' +
							'</small>' +
						'</div>' +
						'<hr />' +
					'</div>'
		); //add input box

		$('#date_' + xj ).datetimepicker({
			format:'YYYY-MM-DD',
			useCurrent: false,
		})
		.on('dp.change dp.show dp.update', function() {
			$('#form').bootstrapValidator('revalidateField', 'srj[' + xj + '][date]');
		});
		
		$('#wts_' + xj + ', #wte_' + xj + ', #ts_1_' + xj + ', #te_1_' + xj + ', #ts_2_' + xj + ', #te_2_' + xj).datetimepicker({
			format: 'h:mm A',
			useCurrent: false,
		});
		
		$('#job_perform_' + xj + ', #ds_1_' + xj + ', #de_1_' + xj + ', #ds_2_' + xj + ', #de_2_' + xj ).keyup(function() {
			uch(this);
		});
		
		$('#fr_' + xj + ', #wtv_' + xj + ', #accommodation_' + xj ).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField',	$('.rowjob')	.find('[name="srj[' + xj + '][date]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowjob')	.find('[name="srj[' + xj + '][labour]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowjob')	.find('[name="srj[' + xj + '][1][meter_start]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowjob')	.find('[name="srj[' + xj + '][2][meter_start]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowjob')	.find('[name="srj[' + xj + '][1][meter_end]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowjob')	.find('[name="srj[' + xj + '][2][meter_end]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowjob')	.find('[name="srj[' + xj + '][food_rate]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowjob')	.find('[name="srj[' + xj + '][labour_leader]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowjob')	.find('[name="srj[' + xj + '][labour_non_leader]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowjob')	.find('[name="srj[' + xj + '][working_type_value]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowjob')	.find('[name="srj[' + xj + '][overtime_hour]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowjob')	.find('[name="srj[' + xj + '][accommodation_rate]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowjob')	.find('[name="srj[' + xj + '][accommodation]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowjob')	.find('[name="srj[' + xj + '][travel_hour]"]'));
	}
});

$(wrapjobnd).on("click",".remove_job", function(e){
	var jobndId = $(this).data('id');

	//user click on remove text
	e.preventDefault();

	var $row = $(this).parent().parent().parent();
	var $option1 = $row.find('[name="srj[' + jobndId + '][date]"]');
	var $option2 = $row.find('[name="srj[' + jobndId + '][labour]"]');
	var $option3 = $row.find('[name="srj[' + jobndId + '][1][meter_start]"]');
	var $option4 = $row.find('[name="srj[' + jobndId + '][2][meter_start]"]');
	var $option5 = $row.find('[name="srj[' + jobndId + '][1][meter_end]"]');
	var $option6 = $row.find('[name="srj[' + jobndId + '][2][meter_end]"]');
	var $option7 = $row.find('[name="srj[' + jobndId + '][food_rate]"]');
	var $option8 = $row.find('[name="srj[' + jobndId + '][labour_leader]"]');
	var $option9 = $row.find('[name="srj[' + jobndId + '][labour_non_leader]"]');
	var $option10 = $row.find('[name="srj[' + jobndId + '][working_type_value]"]');
	var $option11 = $row.find('[name="srj[' + jobndId + '][overtime_hour]"]');
	var $option12 = $row.find('[name="srj[' + jobndId + '][accommodation_rate]"]');
	var $option13 = $row.find('[name="srj[' + jobndId + '][accommodation]"]');
	var $option14 = $row.find('[name="srj[' + jobndId + '][travel_hour]"]');

	// $($row).css({"color": "red", "border": "2px solid red"});

	$('#form').bootstrapValidator('removeField', $option1);
	$('#form').bootstrapValidator('removeField', $option2);
	$('#form').bootstrapValidator('removeField', $option3);
	$('#form').bootstrapValidator('removeField', $option4);
	$('#form').bootstrapValidator('removeField', $option5);
	$('#form').bootstrapValidator('removeField', $option6);
	$('#form').bootstrapValidator('removeField', $option7);
	$('#form').bootstrapValidator('removeField', $option8);
	$('#form').bootstrapValidator('removeField', $option9);
	$('#form').bootstrapValidator('removeField', $option10);
	$('#form').bootstrapValidator('removeField', $option11);
	$('#form').bootstrapValidator('removeField', $option12);
	$('#form').bootstrapValidator('removeField', $option13);
	$('#form').bootstrapValidator('removeField', $option14);
	$row.remove();
	xj--;
})

/////////////////////////////////////////////////////////////////////////////////////////
// add problem and solution : add and remove row

var maxffeedProb	= 10; //maximum input boxes allowed
var addbtnfeedProb	= $(".add_feedProb");
var wrapfeedProb	= $(".feedProb_wrap");

var xfp = <?=($serviceReport->hasmanyfeedproblem()->get()->count() == 0)?1:$serviceReport->hasmanyfeedproblem()->get()->count() ?>;
$(addbtnfeedProb).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(xfp < maxffeedProb){
		xfp++;
		wrapfeedProb.append(
					'<div class="rowfeedProb">' +
						'<div class="col-sm-12 form-row ">' +
							'<div class="col-sm-1 text-danger">' +
									'<i class="fas fa-trash remove_feedProb" aria-hidden="true" id="delete_feedProb_' + xfp + '" data-id="' + xfp + '"></i>' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srfP.*.problem') ? 'has-error' : '' }}">' +
								'<textarea name="srfP[' + xfp + '][problem]" value="{!! @$value !!}" id="problem_' + xfp + '" class="form-control" autocomplete="off" placeholder="Problem" /></textarea>' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srfP.*.solution') ? 'has-error' : '' }}">' +
								'<textarea name="srfP[' + xfp + '][solution]" value="{!! @$value !!}" id="solution_' + xfp + '" class="form-control" autocomplete="off" placeholder="Solution" /></textarea>' +
							'</div>' +
						'</div>' +
					'</div>'
		); //add input box
		$('#problem_' + xfp + ', #solution_' + xfp).keyup(function() {
			tch(this);
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField', $('.rowfeedProb').find('[name="srfP[' + xfp + '][problem]"]'));
		$('#form').bootstrapValidator('addField', $('.rowfeedProb').find('[name="srfP[' + xfp + '][solution]"]'));
	}
});

$(wrapfeedProb).on("click",".remove_feedProb", function(e){
	//user click on remove text
	var fprobId = $(this).data('id');
	e.preventDefault();
	var $row = $(this).parent().parent();

	var $optsfprob1 = $row.find('[name="srfP[' + fprobId + '][problem]"]');
	var $optsfprob2 = $row.find('[name="srfP[' + fprobId + '][solution]"]');

	// $($optsfprob1).css({"color": "red", "border": "2px solid red"});

	$('#form').bootstrapValidator('removeField', $optsfprob1 );
	$('#form').bootstrapValidator('removeField', $optsfprob2 );
	$row.remove();
	xfp--;
})

/////////////////////////////////////////////////////////////////////////////////////////
// add request and action : add and remove row

var maxffeedReq	= 10; //maximum input boxes allowed
var addbtnfeedReq	= $(".add_feedReq");
var wrapfeedReq	= $(".feedReq_wrap");

var xfr = <?=($serviceReport->hasmanyfeedrequest()->get()->count() == 0)?1:$serviceReport->hasmanyfeedrequest()->get()->count() ?>;
$(addbtnfeedReq).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(xfr < maxffeedReq){
		xfr++;
		wrapfeedReq.append(
					'<div class="rowfeedReq">' +
						'<div class="col-sm-12 form-row ">' +
							'<div class="col-sm-1 text-danger">' +
									'<i class="fas fa-trash remove_feedReq" aria-hidden="true" id="delete_feedReq_' + xfr + '" data-id="' + xfr + '"></i>' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srfR.*.request') ? 'has-error' : '' }}">' +
								'<input type="text" name="srfR[' + xfr + '][request]" value="{!! @$value !!}" id="request_' + xfr + '" class="form-control" autocomplete="off" placeholder="Additional Request" />' +
							'</div>' +
							'<div class="form-group col {{ $errors->has('srfR.*.action') ? 'has-error' : '' }}">' +
								'<input type="text" name="srfR[' + xfr + '][action]" value="{!! @$value !!}" id="action_' + xfr + '" class="form-control" autocomplete="off" placeholder="Action (Fill By Management)" />' +
							'</div>' +
						'</div>' +
					'</div>'
		); //add input box
		$('#request_' + xfr + ', #action_' + xfr).keyup(function() {
			tch(this);
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField', $('.rowfeedReq').find('[name="srfR[' + xfr + '][request]"]'));
		$('#form').bootstrapValidator('addField', $('.rowfeedReq').find('[name="srfR[' + xfr + '][action]"]'));
	}
});

$(wrapfeedReq).on("click",".remove_feedReq", function(e){
	//user click on remove text
	var fReqId = $(this).data('id');
	e.preventDefault();
	var $row = $(this).parent().parent();

	var $optsfReq1 = $row.find('[name="srfR[' + fReqId + '][request]"]');
	var $optsfReq2 = $row.find('[name="srfR[' + fReqId + '][action]"]');

	// $($optsfReq1).css({"color": "red", "border": "2px solid red"});

	$('#form').bootstrapValidator('removeField', $optsfReq1 );
	$('#form').bootstrapValidator('removeField', $optsfReq2 );
	$row.remove();
    xfr--;
})

/////////////////////////////////////////////////////////////////////////////////////////
// add item, quantity and action : add and remove row

var maxffeedItem	= 10; //maximum input boxes allowed
var addbtnfeedItem	= $(".add_feedItem");
var wrapfeedItem	= $(".feedItem_wrap");

var xfi = <?=($serviceReport->hasmanyfeeditem()->get()->count() == 0)?1:$serviceReport->hasmanyfeeditem()->get()->count() ?>;
$(addbtnfeedItem).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(xfi < maxffeedItem){
		xfi++;
		wrapfeedItem.append(
					'<div class="rowfeedItem">' +
						'<div class="form-row col-sm-12">' +
							'<div class="col-sm-1 text-danger">' +
									'<i class="fas fa-trash remove_feedItem" aria-hidden="true" id="delete_feedReq" data-id="' + xfi + '"></i>' +
							'</div>' +
							'<div class="form-group col-3 {{ $errors->has('srfI.*.item') ? 'has-error' : '' }}">' +
								'<input type="text" name="srfI[' + xfi + '][item]" value="{!! @$value !!}" id="item_' + xfi + '" class="form-control" autocomplete="off" placeholder="Item" />' +
							'</div>' +
							'<div class="form-group col-3 {{ $errors->has('srfI.*.quantity') ? 'has-error' : '' }}">' +
								'<input type="text" name="srfI[' + xfi + '][quantity]" value="{!! @$value !!}" id="quantity_' + xfi + '" class="form-control" autocomplete="off" placeholder="Quantity" />' +
							'</div>' +
							'<div class="form-group col-3 {{ $errors->has('srfI.*.item_action') ? 'has-error' : '' }}">' +
								'<input type="text" name="srfI[' + xfi + '][item_action]" value="{!! @$value !!}" id="item_action_' + xfi + '" class="form-control" autocomplete="off" placeholder="Action (Fill By Management)" />' +
							'</div>' +
						'</div>' +
					'</div>'
		); //add input box
		$('#item_' + xfi + ', #item_action_' + xfi).keyup(function() {
			tch(this);
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField', $('.rowfeedItem').find('[name="srfI[' + xfi + '][item]"]'));
		$('#form').bootstrapValidator('addField', $('.rowfeedItem').find('[name="srfI[' + xfi + '][quantity]"]'));
		$('#form').bootstrapValidator('addField', $('.rowfeedItem').find('[name="srfI[' + xfi + '][item_action]"]'));
	}
});

$(wrapfeedItem).on("click",".remove_feedItem", function(e){
	//user click on remove text
	var fItemId = $(this).data('id');
	e.preventDefault();
	var $row = $(this).parent().parent();

	var $optsfItem1 = $row.find('[name="srfI[' + fItemId + '][item]"]');
	var $optsfItem2 = $row.find('[name="srfI[' + fItemId + '][quantity]"]');
	var $optsfItem3 = $row.find('[name="srfI[' + fItemId + '][item_action]"]');

	// $($optsfItem1).css({"color": "red", "border": "2px solid red"});

	$('#form').bootstrapValidator('removeField', $optsfItem1 );
	$('#form').bootstrapValidator('removeField', $optsfItem2 );
	$('#form').bootstrapValidator('removeField', $optsfItem3 );
	$row.remove();
	xfi--;
})

/////////////////////////////////////////////////////////////////////////////////////////
// add logistic and price : add and remove row

var maxsrlogistic	= 10; //maximum input boxes allowed
var addbtnsrlogistic	= $(".add_logistic");
var wrapsrLogistic	= $(".logistic_wrap");

var xL = <?=($serviceReport->hasmanylogistic()->get()->count() == 0)?1:$serviceReport->hasmanylogistic()->get()->count() ?>;
$(addbtnsrlogistic).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(xL < maxsrlogistic){
		xL++;
		wrapsrLogistic.append(
					'<div class="rowsrlogistic">' +
						'<div class="form-row col-sm-12">' +
							'<div class="col-sm-1 text-danger">' +
									'<i class="fas fa-trash remove_logistic" aria-hidden="true" id="delete_feedProb_' + xL + '" data-id="' + xL + '"></i>' +
							'</div>' +
							'<div class="form-group col-3 {{ $errors->has('srL.*.vehicle_category') ? 'has-error' : '' }}">' +
								'<select name="srL[' + xL + ']vehicle_category" id="vc_' + xL + '" class="form-control form-control-sm" placeholder="Please choose">' +
									'<option value="">Please choose</option>' +
@foreach( \App\Model\VehicleCategory::all() as $vc )
									'<option value="{{ $vc->id }}" >{{ $vc->category }}</option>' +
@endforeach
								'</select>' +
							'</div>' +
							'<div class="form-group col-3 {{ $errors->has('srL.*.solution') ? 'has-error' : '' }}">' +
								'<select name="srL[' + xL + '][vehicle_id]" id="v_' + xL + '" class="form-control form-control-sm" placeholder="Please choose">' +
									'<option value="" data-chained="">Please choose</option>' +
@foreach( \App\Model\Vehicle::all() as $v )
									'<option value="{{ $v->id }}"  data-chained="{{ $v->vehicle_category_id }}" >{{ $v->vehicle }}</option>' +
@endforeach
								'</select>' +
							'</div>' +
							'<div class="form-group col-3 {{ $errors->has('srL.*.description') ? 'has-error' : '' }}">' +
								'<input type="text" name="srL[' + xL + '][description]" value="{{ @$value }}" id="description_' + xL + '" class="form-control form-control-sm" placeholder="Description">' +
							'</div>' +
							'<div class="form-group col-2 {{ $errors->has('srL.*.charge') ? 'has-error' : '' }}">' +
								'<input type="text" name="srL[' + xL + '][charge]" value="{{ @$value }}" id="charge_' + xL + '" class="form-control form-control-sm logistic_charge" placeholder="Charge (MYR)">' +
							'</div>' +
						'</div>' +
					'</div>'
		); //add input box

		$('#vc_' + xL + ', #v_' + xL ).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});
		
		$('#v_' + xL).chainedTo('#vc_' + xL);
		
		$('#description_' + xL).keyup(function() {
			tch(this);
		});
		//bootstrap validate
		$('#form').bootstrapValidator('addField', $('.rowsrlogistic').find('[name="srL[' + xL + '][vehicle_id]"]'));
		$('#form').bootstrapValidator('addField', $('.rowsrlogistic').find('[name="srL[' + xL + '][description]"]'));
		$('#form').bootstrapValidator('addField', $('.rowsrlogistic').find('[name="srL[' + xL + '][charge]"]'));
	}
});

$(wrapsrLogistic).on("click",".remove_logistic", function(e){
	//user click on remove text
	var srlogist = $(this).data('id');
	e.preventDefault();
	var $row = $(this).parent().parent();

	var $optsrlogist1 = $row.find('[name="srL[' + srlogist + '][vehicle_id]"]');
	var $optsrlogist2 = $row.find('[name="srL[' + srlogist + '][description]"]');
	var $optsrlogist3 = $row.find('[name="srL[' + srlogist + '][charge]"]');

	// $($optsfItem1).css({"color": "red", "border": "2px solid red"});

	$('#form').bootstrapValidator('removeField', $optsrlogist1 );
	$('#form').bootstrapValidator('removeField', $optsrlogist2 );
	$('#form').bootstrapValidator('removeField', $optsrlogist3 );
	$row.remove();
	xL--;

	// update logistic grand total
	update_grandtotal_logistic();
})

/////////////////////////////////////////////////////////////////////////////////////////
// add additional charges : add and remove row

var maxsraddcharge	= 10; //maximum input boxes allowed
var addbtnsraddch	= $(".add_addchrages");
var wrapsrChargess	= $(".addcharges_wrap");

var xsrAddCh = <?=($serviceReport->hasmanyadditionalcharge()->get()->count() == 0)?0:$serviceReport->hasmanyadditionalcharge()->get()->count() ?>;
$(addbtnsraddch).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(xsrAddCh < maxsraddcharge){
		xsrAddCh++;
		wrapsrChargess.append(
					'<div class="rowsraddcharges">' +
						'<div class="form-row col-sm-12">' +
							'<div class="col-sm-1 text-danger">' +
									'<i class="fas fa-trash remove_addcharges" aria-hidden="true" id="delete_addcharge_' + xsrAddCh + '" data-id="' + xsrAddCh + '"></i>' +
							'</div>' +
							'<div class="form-group col-3 {{ $errors->has('srAC.*.amount_id') ? 'has-error' : '' }}">' +
								'<select name="srAC[' + xsrAddCh + '][amount_id]" id="aid_' + xsrAddCh + '" class="form-control form-control-sm" placeholder="Please choose">' +
									'<option value="">Please choose</option>' +
@foreach( \App\Model\Amount::all() as $am )
									'<option value="{{ $am->id }}" >{{ $am->amount }}</option>' +
@endforeach
								'</select>' +
							'</div>' +
							'<div class="form-group col-6 {{ $errors->has('srAC.*.description') ? 'has-error' : '' }}">' +
								'<input type="text" name="srAC[' + xsrAddCh + '][description]" value="{!! @$value !!}" class="form-control form-control-sm" id="description_amount_' + xsrAddCh + '" placeholder="Description" >' +
							'</div>' +
							'<div class="form-group col-2 {{ $errors->has('srAC.*.value') ? 'has-error' : '' }}">' +
								'<input type="text" name="srAC[' + xsrAddCh + '][value]" value="{{ @$value }}" id="value_' + xsrAddCh + '" class="form-control form-control-sm value" placeholder="Amount (MYR)">' +
							'</div>' +
						'</div>' +
					'</div>'
		); //add input box

		$('#aid_' + xsrAddCh).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});
		
		$('#description_amount_' + xsrAddCh).keyup(function() {
			tch(this);
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField', $('.rowsraddcharges').find('[name="srAC[' + xsrAddCh + '][amount_id]"]'));
		$('#form').bootstrapValidator('addField', $('.rowsraddcharges').find('[name="srAC[' + xsrAddCh + '][description]"]'));
		$('#form').bootstrapValidator('addField', $('.rowsraddcharges').find('[name="srAC[' + xsrAddCh + '][value]"]'));
	}
});

$(wrapsrChargess).on("click",".remove_addcharges", function(e){
	//user click on remove text
	var srlAdditionalCharges = $(this).data('id');
	e.preventDefault();
	var $row = $(this).parent().parent();

	var $optsrlAdditionalCharges1 = $row.find('[name="srAC[' + srlAdditionalCharges + '][amount_id]"]');
	var $optsrlAdditionalCharges2 = $row.find('[name="srAC[' + srlAdditionalCharges + '][description]"]');
	var $optsrlAdditionalCharges3 = $row.find('[name="srAC[' + srlAdditionalCharges + '][value]"]');

	// $($optsfItem1).css({"color": "red", "border": "2px solid red"});

	$('#form').bootstrapValidator('removeField', $optsrlAdditionalCharges1 );
	$('#form').bootstrapValidator('removeField', $optsrlAdditionalCharges2 );
	$('#form').bootstrapValidator('removeField', $optsrlAdditionalCharges3 );
	$row.remove();
	xsrAddCh--;

	// update logistic grand total
	update_grandtotal_addChar();
})

/////////////////////////////////////////////////////////////////////////////////////////
// add discount : add and remove row

var maxdiscount	= 1; //maximum input boxes allowed
var addbtndiscount	= $(".add_discount");
var wrapsrdiscount	= $(".discount_wrap");

var xdiscount = <?=($serviceReport->hasonediscount()->get()->count() == 0)?0:$serviceReport->hasonediscount()->get()->count() ?>;
$(addbtndiscount).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(xdiscount < maxdiscount){
		xdiscount++;
		wrapsrdiscount.append(
					'<div class="rowsrdiscount">' +
						'<div class="form-row col-sm-12">' +
							'<div class="col-sm-1 text-danger">' +
									'<i class="fas fa-trash remove_discount" aria-hidden="true" id="delete_discount_' + xdiscount + '" data-id="' + xdiscount + '"></i>' +
							'</div>' +
							'<div class="form-group col-3 {{ $errors->has('srDisc.*.discount_id') ? 'has-error' : '' }}">' +
								'<select name="srDisc[' + xdiscount + '][discount_id]" id="srdisc_' + xdiscount + '" class="form-control form-control-sm discount_id" placeholder="Please choose">' +
									'<option value="">Please choose</option>' +
@foreach( \App\Model\Discount::all() as $disc )
									'<option value="{{ $disc->id }}">{{ $disc->discount_type }}</option>' +
@endforeach
								'</select>' +
							'</div>' +
							'<div class="form-group col-2 {{ $errors->has('srDisc.*.value') ? 'has-error' : '' }}">' +
								'<input type="text" name="srDisc[' + xdiscount + '][value]" value="{{ @$value }}" id="value_' + xdiscount + '" class="form-control form-control-sm value_disc" placeholder="Value">' +
							'</div>' +
							'<div class="col-3">' +
							'&nbsp;' +
							'</div>' +
							'<div class="col-1">' +
							'=' +
							'</div>' +
							'<div class="col-2">' +
							'RM <span id="discount_value">0</span>' +
							'</div>' +
						'</div>' +
					'</div>'
		); //add input box

		$('#srdisc_' + xdiscount).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});
		
		//bootstrap validate
		$('#form').bootstrapValidator('addField', $('.rowsrdiscount').find('[name="srDisc[' + xdiscount + '][discount_id]"]'));
		$('#form').bootstrapValidator('addField', $('.rowsrdiscount').find('[name="srDisc[' + xdiscount + '][value]"]'));
	}
});

$(wrapsrdiscount).on("click",".remove_discount", function(e){
	//user click on remove text
	var srDiscount = $(this).data('id');
	e.preventDefault();
	var $row = $(this).parent().parent();

	var $optsrDiscount1 = $row.find('[name="srDisc[' + srDiscount + '][discount_id]"]');
	var $optsrDiscount2 = $row.find('[name="srDisc[' + srDiscount + '][value]"]');

	// $($optsrDiscount1).css({"color": "red", "border": "2px solid red"});

	$('#form').bootstrapValidator('removeField', $optsrDiscount1 );
	$('#form').bootstrapValidator('removeField', $optsrDiscount2 );
	$row.remove();
	xdiscount--;

	// update logistic grand total
	// update_grandtotal_addChar();
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

/////////////////////////////////////////////////////////////////////////////////////////
// ajax post delete row job feed prob
$(document).on('click', '.delete_feedProb', function(e){
	var feedProbId = $(this).data('id');
	SwalDeleteFeedProblem(feedProbId);
	e.preventDefault();
});

function SwalDeleteFeedProblem(feedProbId){
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
					url: '{{ url('srFeedProb') }}' + '/' + feedProbId,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: feedProbId,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_feedProb_' + feedProbId).parent().parent().remove();
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
// ajax post delete row job feed request
$(document).on('click', '.delete_feedReq', function(e){
	var feedReqId = $(this).data('id');
	SwalDeleteFeedRequest(feedReqId);
	e.preventDefault();
});

function SwalDeleteFeedRequest(feedReqId){
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
					url: '{{ url('srFeedReq') }}' + '/' + feedReqId,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: feedReqId,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_feedReq_' + feedReqId).parent().parent().remove();
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
// ajax post delete row sr logistic
$(document).on('click', '.delete_logistic', function(e){
	var srlogistik = $(this).data('id');
	SwalDeleteSRLogistic(srlogistik);
	e.preventDefault();
});

function SwalDeleteSRLogistic(srlogistik){
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
					url: '{{ url('srLogistic') }}' + '/' + srlogistik,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: srlogistik,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_logistic_' + srlogistik).parent().parent().remove();
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
// ajax post delete row sr additional chrages
$(document).on('click', '.delete_addcharge', function(e){
	var sraddC = $(this).data('id');
	SwalDeleteSRAddCharges(sraddC);
	e.preventDefault();
});

function SwalDeleteSRAddCharges(sraddC){
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
					url: '{{ url('srAddCharge') }}' + '/' + sraddC,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: sraddC,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_logistic_' + sraddC).parent().parent().remove();
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
// ajax post delete row sr discount chrages
$(document).on('click', '.delete_discount', function(e){
	var srDisc = $(this).data('id');
	SwalDeleteSRDiscount(srDisc);
	e.preventDefault();
});

function SwalDeleteSRDiscount(srDisc){
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
					url: '{{ url('srDiscount') }}' + '/' + srDisc,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: srDisc,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_logistic_' + srDisc).parent().parent().remove();
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
			var totalallowancelabour = ((($(all).val()*100)/100) + ((($(anll).val()*100)/100) * ((countnonleader * 100)/100))) / ( (( $(wtv).val() )*100) / 100 );
			var totalallowancelabour0 = ((totalallowancelabour * 100)/100) * (($(wtv).val() * 100) / 100);
	} else {
		var totalallowancelabour = 0;
	}
	$(tla).text( totalallowancelabour.toFixed(2) );
	$(tla1).text( totalallowancelabour0.toFixed(2) );
	$(tla2).text( totalallowancelabour0.toFixed(2) );

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
	update_grandtotal_sr();
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
	update_grandtotal_sr();
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
	update_grandtotal_sr();
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
	update_grandtotal_sr();
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
	update_grandtotal_sr();
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
	update_grandtotal_sr();
});

$(document).on('keyup', '.allowanceleaderlabour', function () {
	var anll = $(this).parent().parent().parent().children().children().children('.allowancenonleaderlabour');
	var anl = $(this).parent().parent().parent().children().children().children('.allowancenonleader');
	var wtv = $(this).parent().parent().parent().children().children().children('.workingtypevalue');
	var tla = $(this).parent().parent().parent().children().children().children('.totallabourallowance');

	var tla1 = $(this).parent().parent().parent().children().children().children('.totallabourallowance1');
	var tla2 = $(this).parent().parent().parent().children().children().children('.totallabourallowance2');

	// $(tla1).css({"color": "red", "border": "2px solid red"});
	// $(tla2).css({"color": "red", "border": "2px solid red"});
	// console.log($(this).val());

	var tlanew = ( (($(this).val() * 100) / 100) + ((($(anll).val() * 100) / 100) * (($(anl).text() * 100) / 100)) ) / (($(wtv).val() * 100) / 100);
	var tlanew0 = ((tlanew * 100)/ 100) * (($(wtv).val() * 100) / 100);

	$(tla).text(tlanew.toFixed(2));
	$(tla1).text(tlanew0.toFixed(2));
	$(tla2).text(tlanew0.toFixed(2));

	// overtime section
	var oc1 = $(this).parent().parent().parent().children().children().children('.overtimeconstant1');
	var oc1 = $(this).parent().parent().parent().children().children().children('.overtimeconstant1');
	var oc2 = $(this).parent().parent().parent().children().children().children('.overtimeconstant2');
	var oh = $(this).parent().parent().parent().children().children().children('.overtimehour');
	var to = $(this).parent().parent().parent().children().children().children('.totalovertime');

	var totalovertimee = ((($(tla1).text() * 100)/100) * ((( $(oc1).text() ) * 100 ) /100) * ((( $(oc2).text() ) * 100 ) /100) * (( $(oh).val() * 100) / 100))
	$(to).text(totalovertimee.toFixed(2));

	// travel hour section
	var thc = $(this).parent().parent().parent().children().children().children('.travelhourconstant');
	var th = $(this).parent().parent().parent().children().children().children('.travelhour');
	var tth = $(this).parent().parent().parent().children().children().children('.totaltravelhour');

	var totaltravho = ((($(tla2).text() * 100) / 100) * (($(thc).text() * 100) / 100) * (($(th).val() * 100) / 100));
	$(tth).text(totaltravho.toFixed(2));

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
	update_grandtotal_sr();
});

$(document).on('keyup', '.allowancenonleaderlabour', function () {
	var all = $(this).parent().parent().parent().children().children().children('.allowanceleaderlabour');
	var anl = $(this).parent().parent().parent().children().children().children('.allowancenonleader');
	var wtv = $(this).parent().parent().parent().children().children().children('.workingtypevalue');
	var tla = $(this).parent().parent().parent().children().children().children('.totallabourallowance');
	var tla1 = $(this).parent().parent().parent().children().children().children('.totallabourallowance1');
	var tla2 = $(this).parent().parent().parent().children().children().children('.totallabourallowance2');

	// $(anll).css({"color": "red", "border": "2px solid red"});
	// console.log($(this).val());

	var tlanew = ( (($(all).val() * 100) / 100) + ((($(this).val() * 100) / 100) * (($(anl).text() * 100) / 100)) ) / (($(wtv).val() * 100) / 100);
	var tlanew0 = ((tlanew * 100) / 100) * (($(wtv).val() * 100) / 100);

	$(tla).text(tlanew.toFixed(2));
	$(tla1).text(tlanew0.toFixed(2));
	$(tla2).text(tlanew0.toFixed(2));

	// overtime section
	var oc1 = $(this).parent().parent().parent().children().children().children('.overtimeconstant1');
	var oc1 = $(this).parent().parent().parent().children().children().children('.overtimeconstant1');
	var oc2 = $(this).parent().parent().parent().children().children().children('.overtimeconstant2');
	var oh = $(this).parent().parent().parent().children().children().children('.overtimehour');
	var to = $(this).parent().parent().parent().children().children().children('.totalovertime');

	var totalovertimee = ((($(tla1).text() * 100)/100) * ((( $(oc1).text() ) * 100 ) /100) * ((( $(oc2).text() ) * 100 ) /100) * (( $(oh).val() * 100) / 100))
	$(to).text(totalovertimee.toFixed(2));

	// travel hour section
	var thc = $(this).parent().parent().parent().children().children().children('.travelhourconstant');
	var th = $(this).parent().parent().parent().children().children().children('.travelhour');
	var tth = $(this).parent().parent().parent().children().children().children('.totaltravelhour');

	var totaltravho = ((($(tla2).text() * 100) / 100) * (($(thc).text() * 100) / 100) * (($(th).val() * 100) / 100));
	$(tth).text(totaltravho.toFixed(2));

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
	update_grandtotal_sr();
});

$(document).on('change', '.workingtypevalue', function () {
	var all = $(this).parent().parent().parent().children().children().children('.allowanceleaderlabour');
	var anl = $(this).parent().parent().parent().children().children().children('.allowancenonleader');
	var anll = $(this).parent().parent().parent().children().children().children('.allowancenonleaderlabour');
	var tla = $(this).parent().parent().parent().children().children().children('.totallabourallowance');
	var tla1 = $(this).parent().parent().parent().children().children().children('.totallabourallowance1');
	var tla2 = $(this).parent().parent().parent().children().children().children('.totallabourallowance2');

	// $(anll).css({"color": "red", "border": "2px solid red"});
	// console.log($(this).val());

	var tlanew = ( (($(all).val() * 100) / 100) + ((($(anll).val() * 100) / 100) * (($(anl).text() * 100) / 100)) ) / (($(this).val() * 100) / 100);
	var tlanew0 = ((tlanew * 100)/ 100) * (($(this).val() * 100) / 100);

	$(tla).text(tlanew.toFixed(2));
	$(tla1).text(tlanew0.toFixed(2));
	$(tla2).text(tlanew0.toFixed(2));

	// overtime section
	var oc1 = $(this).parent().parent().parent().children().children().children('.overtimeconstant1');
	var oc1 = $(this).parent().parent().parent().children().children().children('.overtimeconstant1');
	var oc2 = $(this).parent().parent().parent().children().children().children('.overtimeconstant2');
	var oh = $(this).parent().parent().parent().children().children().children('.overtimehour');
	var to = $(this).parent().parent().parent().children().children().children('.totalovertime');

	var totalovertimee = ((($(tla1).text() * 100)/100) * ((( $(oc1).text() ) * 100 ) /100) * ((( $(oc2).text() ) * 100 ) /100) * (( $(oh).val() * 100) / 100))
	$(to).text(totalovertimee.toFixed(2));

	// travel hour section
	var thc = $(this).parent().parent().parent().children().children().children('.travelhourconstant');
	var th = $(this).parent().parent().parent().children().children().children('.travelhour');
	var tth = $(this).parent().parent().parent().children().children().children('.totaltravelhour');

	var totaltravho = ((($(tla2).text() * 100) / 100) * (($(thc).text() * 100) / 100) * (($(th).val() * 100) / 100));
	$(tth).text(totaltravho.toFixed(2));

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
	update_grandtotal_sr();
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
	update_grandtotal_sr();
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
	update_grandtotal_sr();
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
	update_grandtotal_sr();
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
	update_grandtotal_sr();
});

$(document).on('keyup', '.logistic_charge', function () {
	update_grandtotal_logistic();
	update_grandtotal_sr();
});

$(document).on('keyup', '.value', function () {
	update_grandtotal_addChar();
	update_grandtotal_sr();
});

$(document).on('keyup', '.value_disc', function () {
	// check for percentage or value
	var perval = $('#srdisc_1').val();
	var pvalu = $('.value_disc').val();

	var gt = $('#grandtotal').text();
	var gtl = $('#grandtotallogistic').text();
	var gtac = $('#grandtotaladdcharges').text();

	var gtdisc = $('#discount_value').text();

	if(perval == 1) {		// percentage
		var td = ( ( ((gt * 100) / 100) + ((gtl * 100) / 100) + ((gtac * 100) / 100) ) * (($(this).val() * 100) / 100) ) / 100;
		console.log(td.toFixed(2));
		$('#discount_value').text( td.toFixed(2) );

	} else {
		if(perval == 2){
			$('#discount_value').text(pvalu);
		}
	}
	update_grandtotal_sr();
});

$(document).on('change', '#srdisc_1', function () {
	var perval = $(this).val();

	var pvalu = $('.value_disc').val();

	var gt = $('#grandtotal').text();
	var gtl = $('#grandtotallogistic').text();
	var gtac = $('#grandtotaladdcharges').text();

	var gtdisc = $('#discount_value').text();

	if(perval == 1) {
		var td = ( ( ((gt * 100) / 100) + ((gtl * 100) / 100) + ((gtac * 100) / 100) ) * (($(this).val() * 100) / 100) ) / 100;
		$('#discount_value').text( td.toFixed(2) );
	} else {
		if(perval == 2) {
			$('#discount_value').text(pvalu);
		}
	}
	update_grandtotal_sr();
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

// update grand total logistic
function update_grandtotal_logistic() {
	var Nodelistlogist = $(".logistic_charge");
	var logisticSum = 0;
	for (var node = Nodelistlogist.length - 1; node >= 0; node--) {
		// Nodelistlogist[node].style.backgroundColor = "red";

		logisticSum = ( (logisticSum * 10000) + (Nodelistlogist[node].value * 10000) ) / 10000;

		// console.log(Nodelistlogist[node].innerHTML);
		// console.log(logisticSum);
	}
	$('#grandtotallogistic').text( logisticSum.toFixed(2) );
};

// update grand total additional charges
function update_grandtotal_addChar() {
	var Nodelistvaladdcharge = $(".value");
	var addChajSum = 0;
	for (var node = Nodelistvaladdcharge.length - 1; node >= 0; node--) {
		// Nodelistvaladdcharge[node].style.backgroundColor = "red";

		addChajSum = ( (addChajSum * 10000) + (Nodelistvaladdcharge[node].value * 10000) ) / 10000;

		// console.log(Nodelistvaladdcharge[node].value);
		// console.log(addChajSum);
	}
	$('#grandtotaladdcharges').text( addChajSum.toFixed(2) );
};

// update grand total service report
function update_grandtotal_sr() {
	var gt = $('#grandtotal').text();
	var gtl = $('#grandtotallogistic').text();
	var gtac = $('#grandtotaladdcharges').text();

	var gtdisc = $('#discount_value').text();

	var grandtotal = ((gt * 100) / 100) + ((gtl * 100) / 100) + ((gtac * 100) / 100) - ((gtdisc * 100) / 100);

	$('#grandtotaldiscount').text( grandtotal.toFixed(2) );
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
@for($q=1; $q < 51; $q++)
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
@for ($u=1; $u < 100; $u++)

		'sr[{{ $u }}][attended_by]': {
			validators: {
				notEmpty: {
					message: 'Please choose. '
				},
			}
		},

@endfor
		remarks: {
			validators : {
				notEmpty: {
					message: 'This field cannot be empty. '
				},
			}
		},
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

@for($xc = 1; $xc < 500; $xc++)
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
		'srj[{{ $xc }}][srjde][1][meter_start]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
				integer: {
					message: 'The value is not an integer. '
				},
				greaterThan: {
					// value: 'srj[{{ $xc }}][srjde][1][meter_end]',
					value: 0,
					inclusive: true,
					message: 'The meter has to be greater or equal than than 0. '
				},
			}
		},
		'srj[{{ $xc }}][srjde][1][meter_end]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
				integer: {
					message: 'The value is not an integer. '
				},
				greaterThan: {
					value: 'srj[{{ $xc }}][srjde][1][meter_start]',
					inclusive: true,
					message: 'The meter has to be greater or equal than than Meter Start. '
				},
			}
		},
		'srj[{{ $xc }}][srjde][2][meter_start]': {
			validators : {
				integer: {
					message: 'The value is not an integer. '
				},
				greaterThan: {
					value: 'srj[{{ $xc }}][srjde][1][meter_end]',
					inclusive: true,
					message: 'The meter has to be less or equal than than Meter End. '
				},
			}
		},
		'srj[{{ $xc }}][srjde][2][meter_end]': {
			validators : {
				integer: {
					message: 'The value is not an integer. '
				},
				greaterThan: {
					value: 'srj[{{ $xc }}][srjde][2][meter_start]',
					inclusive: true,
					message: 'The meter has to be greater or equal than than Meter Start. '
				},
			}
		},
		'srj[{{ $xc }}][food_rate]': {
			validators : {
				notEmpty: {
					message: 'Please choose. '
				},
			}
		},
		'srj[{{ $xc }}][labour_leader]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
				numeric: {
					separator : '.',
					message: 'Invalid input value. (150.00) '
				}
			}
		},
		'srj[{{ $xc }}][labour_non_leader]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
				numeric: {
					separator : '.',
					message: 'Invalid input value. (100.00) '
				}
			}
		},
		'srj[{{ $xc }}][working_type_value]': {
			validators : {
				notEmpty: {
					message: 'Please choose. '
				},
			}
		},
		'srj[{{ $xc }}][overtime_hour]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
				greaterThan: {
					value: 0,
					inclusive: true,
					message: 'The hour has to be greater or equal to 0. '
				},
			}
		},
		'srj[{{ $xc }}][accommodation_rate]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
				greaterThan: {
					value: 100,
					inclusive: true,
					message: 'The accommodation rate has to be greater or equal to 100. '
				},
			}
		},
		'srj[{{ $xc }}][accommodation]': {
			validators : {
				notEmpty: {
					message: 'Please choose. '
				},
			}
		},
		'srj[{{ $xc }}][travel_hour]': {
			validators : {
				notEmpty: {
					message: 'This field cant be empty. '
				},
				integer: {
					message: 'Invalid input. '
				},
			}
		},
@endfor
@for($xfprob = 1; $xfprob < 10; $xfprob++)
		'srfP[{{ $xfprob }}][problem]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
			}
		},
		'srfP[{{ $xfprob }}][solution]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
			}
		},
@endfor
@for($xfReq = 1; $xfReq < 10; $xfReq++)
		'srfR[{{ $xfReq }}][request]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
			}
		},
		'srfR[{{ $xfReq }}][action]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
			}
		},
@endfor
@for($xfItem = 1; $xfItem < 10; $xfItem++)
		'srfI[{{ $xfItem }}][item]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
			}
		},
		'srfI[{{ $xfItem }}][quantity]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
				integer: {
					message: 'Invalid input value. '
				}
			}
		},
		'srfI[{{ $xfItem }}][item_action]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
			}
		},
@endfor
		feed_new_machine: {
			validators: {
				notEmpty: {
					message: 'Please choose. '
				},
			}
		},
		feed_problem_customer_site: {
			validators: {
				notEmpty: {
					message: 'Please choose. '
				},
			}
		},
@for($xlogistic = 1; $xlogistic < 10; $xlogistic++)
		'srL[{{ $xlogistic }}][vehicle_id]': {
			validators : {
				notEmpty: {
					message: 'Please choose. '
				},
			}
		},
		'srL[{{ $xlogistic }}][charge]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
				numeric: {
					separator : '.',
					message: 'Invalid input value. '
				}
			}
		},
		// 'srL[{{ $xlogistic }}][description]': {
		// 	validators : {
		// 		notEmpty: {
		// 			message: 'Please insert this field. '
		// 		},
		// 	}
		// },
@endfor
@for($xaddcharges = 1; $xaddcharges < 10; $xaddcharges++)
		'srAC[{{ $xaddcharges }}][amount_id]': {
			validators : {
				notEmpty: {
					message: 'Please choose. '
				},
			}
		},
		'srAC[{{ $xaddcharges }}][description]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
			}
		},
		'srAC[{{ $xaddcharges }}][value]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
				numeric: {
					separator : '.',
					message: 'Invalid input value. '
				},
			}
		},
@endfor
		'srDisc[1][discount_id]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
			}
		},
		'srDisc[1][value]': {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
				numeric: {
					separator : '.',
					message: 'Invalid input value. '
				},
			}
		},
		proceed_id: {
			validators : {
				// notEmpty: {
				// 	message: 'Please choose. '
				// },
			}
		},
		category_id: {
			validators : {
				notEmpty: {
					message: 'Please choose. '
				},
			}
		},
		status_id: {
			validators : {
				notEmpty: {
					message: 'Please choose. '
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

