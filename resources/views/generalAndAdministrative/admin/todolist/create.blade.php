@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header">Create Task</div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')


{!! Form::open(['route' => ['todoSchedule.store'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true, 'files' => true]) !!}
@include('generalAndAdministrative.admin.todolist._create')
{!! Form::close() !!}

	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$("#task, #desc").keyup(function() {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
// select2
$("#cat, #prio, #assig, #staff_id_1").select2({
	width: '100%',
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
});

/////////////////////////////////////////////////////////////////////////////////////////
// dateline
$('#line').datetimepicker({
	format:'YYYY-MM-DD',
	useCurrent: false,
})
.on('dp.change dp.show dp.update', function() {
	$('#form').bootstrapValidator('revalidateField', 'dateline');
});

/////////////////////////////////////////////////////////////////////////////////////////
// add attendees : add and remove row
<?php
$sta = \App\Model\Staff::where('active', 1)->whereNotIn('id', [191, 192])->get();
?>

var max_fields	= 10; //maximum input boxes allowed
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
				'<div class="form-row col-sm-12">' +
					'<div class="col-sm-1 text-danger">' +
							'<i class="fas fa-trash remove_position" aria-hidden="true" id="button_delete_' + xs + '" data-id="' + xs + '"></i>' +
					'</div>' +
					'<div class="col">' +
						'<div class="form-group {{ $errors->has('td.*.staff_id') ? 'has-error' : '' }}">' +
							'<select name="td[' + xs + '][staff_id]" id="staff_id_' + xs + '" class="form-control">' +
								'<option value="">Please choose</option>' +
@foreach($sta as $st)
								'<option value="{!! $st->id !!}">{!! $st->hasmanylogin()->where('active', 1)->first()->username !!} {{ $st->name }}</option>' +
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
		$('#form').bootstrapValidator('addField',$('.rowposition').find('[name="sr[' + xs + '][attended_by]"]'));
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
$('#form').bootstrapValidator({
	feedbackIcons: {
		valid: '',
		invalid: '',
		validating: ''
	},
	fields: {
		category_id: {
			validators: {
				notEmpty: {
					message: 'Please choose. '
				},
			}
		},
@for($i = 1; $i <= 10; $i++)
		'td[{!! $i !!}][staff_id]': {
			validators : {
				notEmpty: {
					message: 'Please choose. '
				},
			}
		},
@endfor
		task: {
			validators : {
				notEmpty: {
					message: 'Please insert this field. '
				},
			}
		},
		description: {
			validators: {
				notEmpty: {
					message: 'Please insert this field. '
				},
			}
		},
		dateline: {
			validators : {
				notEmpty: {
					message: 'Please choose date. '
				},
				date: {
					format: 'YYYY-MM-DD',
					message: 'The value is not a valid date. '
				},
			}
		},
		period_reminder: {
			validators : {
				integer: {
					message: 'Please insert days before the dateline. '
				},
			}
		},
		priority_id: {
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