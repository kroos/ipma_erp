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
				<a class="nav-link active" href="{{ route('leaveEditing.index') }}">Leave</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('tcms.index') }}">TCMS</a>
			</li>
		</ul>

		<div class="card">
			<div class="card-header">Leaves Management</div>
			<div class="card-body">
				{{ Form::open(['route' => ['staffLeaveReplacement.store'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true, 'autocomplete' => 'off', 'files' => true]) }}
					@include('generalAndAdministrative.hr.leave.nrl._form')
				{{ Form::close() }}
			</div>
		</div>

	</div>
</div>
@endsection

@section('js')
<?php
use \Carbon\Carbon;
use \App\Model\StaffLeaveReplacement;
use \App\Model\Staff;
use \App\Model\StaffLeave;

$now = Carbon::now();

$sid = Staff::where('active', 1)->orderBy('name', 'asc')->get();
?>
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords


/////////////////////////////////////////////////////////////////////////////////////////
// date time start
$('#dts').datetimepicker({
	format: 'YYYY-MM-DD',
	useCurrent: false,
	maxDate: $('#dte').val(),
	daysOfWeekDisabled: [0],
});

/////////////////////////////////////////////////////////////////////////////////////////
// add replacement leave : add and remove row

var max_fields	= 30; //maximum input boxes allowed
var add_buttons	= $(".add_rl");
var wrappers	= $(".rl_wrap");

var xs = -1;
$(add_buttons).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(xs < max_fields){
		xs++;
		wrappers.append
			(

				'<div class="rowrl">' +
					'<div class="row col-sm-12">' +
						'<div class="col-sm-1">' +
							'<button class="btn btn-danger remove_rl" type="button" id="button_delete_" data-id="">' +
								'<i class="fas fa-trash" aria-hidden="false"></i>' +
							'</button>' +
						'</div>' +
						'<div class="col-sm-3">' +
							'<div class="form-group {{ $errors->has('staff.*.staff_id') ? 'has-error' : '' }}">' +
								'<select name="staff[' + xs +'][staff_id]" class="form-control" id="sid_' + xs + '" placeholder="Please choose staff">' +
									'<option value="">Please choose staff</option>' +
@foreach($sid as $g)
									'<option value="{{ $g-> id }}">{{ $g->hasmanylogin()->where('active', 1)->first()->username }} => {{ $g->name }}</option>' +
@endforeach
								'</select>' +
							'</div>' +
						'</div>' +
						'<div class="col-sm-2">' +
							'<div class="form-group {{ $errors->has('staff.*.working_date') ? 'has-error' : '' }}">' +
								'<input class="form-control" type="text" name="staff[' + xs +'][working_date]" id="wd_' + xs + '" autocomplete="off" placeholder="Working Date">' +
							'</div>' +
						'</div>' +
						'<div class="col-sm-3">' +
							'<div class="form-group {{ $errors->has('staff.*.working_location') ? 'has-error' : '' }}">' +
								'<input class="form-control" type="text" name="staff[' + xs +'][working_location]" id="wl_' + xs + '" autocomplete="off" placeholder="Working Location">' +
							'</div>' +
						'</div>' +
						'<div class="col-sm-3">' +
							'<div class="form-group {{ $errors->has('staff.*.working_reason') ? 'has-error' : '' }}">' +
								'<input class="form-control" type="text" name="staff[' + xs +'][working_reason]" id="wr_' + xs + '" value="Rest Day Sunday" autocomplete="off" placeholder="Working Reason">' +
							'</div>' +
						'</div>' +
					'</div>' +
				'</div>' +
				'<input type="hidden" name="staff[' + xs + '][leave_total]" value="1">' +
				'<input type="hidden" name="staff[' + xs + '][leave_utilize]" value="0">' +
				'<input type="hidden" name="staff[' + xs + '][leave_balance]" value="1">'

			);

		//bootstrap validate
		$('#form').bootstrapValidator('addField',	$('.rowrl')	.find('[name="staff[' + xs +'][staff_id]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowrl')	.find('[name="staff[' + xs +'][working_date]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowrl')	.find('[name="staff[' + xs +'][working_location]"]'));
		$('#form').bootstrapValidator('addField',	$('.rowrl')	.find('[name="staff[' + xs +'][working_reason]"]'));

		$('#sid_' + xs).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});

		$('#wd_' + xs).datetimepicker({
			format:'YYYY-MM-DD',
			useCurrent: false,
		})
		.on('dp.change dp.show dp.update', function() {
			$('#form').bootstrapValidator('revalidateField', 'staff[' + xs + '][working_date]');
		});

		$('#wl_' + xs + ',#wr_' + xs).keyup(function() { tch(this); });
	}
});

$(wrappers).on("click",".remove_rl", function(e){

	//user click on remove text
	e.preventDefault();
	var $row = $(this).parent().parent().parent();

//	var $option1 = $row.find('[name="staff[][main]"]');
//	$('#form').bootstrapValidator('removeField', $option1);

	$row.remove();
    xs--;
})

/////////////////////////////////////////////////////////////////////////////////////////
// bootstrap validator
$(document).ready(function() {
	$('#form').bootstrapValidator({
		feedbackIcons: {
			valid: '',
			invalid: '',
			validating: ''
		},
		fields: {
<?php
$a = 0;
$b = 0;
$c = 0;
$d = 0;
?>
@for( $m=0; $m<=30; $m++ )
			'staff[{{ $a++ }}][staff_id]' : {
				validators: {
					notEmpty: {
						message: 'Please choose staff. '
					}
				},
			},
			'staff[{{ $b++ }}][working_date]': {
				validators: {
					notEmpty: {
						message: 'Please insert working date. '
					},
					date: {
						format: 'YYYY-MM-DD',
						message: 'The value is not a valid date. '
					},
				}
			},
			'staff[{{ $c++ }}][working_location]': {
				validators: {
					notEmpty: {
						message: 'Please insert working location. '
					}
				}
			},
			'staff[{{ $d++ }}][working_reason]': {
				validators: {
					notEmpty: {
						message: 'Please insert working reason. '
					}
				}
			},
@endfor
		}
	});
});	
/////////////////////////////////////////////////////////////////////////////////////////
@endsection

