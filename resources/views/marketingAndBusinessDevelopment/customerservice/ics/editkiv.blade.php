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
				<a class="nav-link" href="{{ route('csOrder.index') }}">Customer Order Item</a>
			</li>
		</ul>
		<div class="card">
			<div class="card-header">Intelligence Customer Service</div>
			<div class="card-body">
				<div class="card">
					<div class="card-header">Add Service Report</div>
					<div class="card-body">
{!! Form::model( $serviceReport, ['route' => ['serviceReport.updatekiv', $serviceReport->id], 'method' => 'PATCH', 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) !!}
@include('marketingAndBusinessDevelopment.customerservice.ics._editkiv')
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
$("#compby1, #compl1, #rem1").keyup(function() {
	// uch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
// autocomplete
$( function() {
	var availableTags = [
		<?php foreach (\App\Model\ICSMachineModel::all() as $key) {
			echo '"'.$key->model.'" '.',';
		} ?>
	];

	$("#model").autocomplete({
		source: availableTags
	});
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

@for($yu = 1; $yu <= $serviceReport->hasmanyattendees()->get()->count(); $yu++)
$('#staff_id_{{ $yu }}').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});
@endfor

$('#inlineRadio2').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
// add position : add and remove row
<?php
$staff = \App\Model\Staff::where('active', 1)->get();
?>

var max_fields	= 10; //maximum input boxes allowed
var add_buttons	= $(".add_position");
var wrappers	= $(".position_wrap");

var xs = <?php echo $serviceReport->hasmanyattendees()->get()->count() ?>;
$(add_buttons).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(xs < max_fields){
		xs++;
		wrappers.append(

					'<div class="rowposition">' +
						'<div class="row col-sm-12">' +
							'<div class="col-sm-1 text-danger">' +
									'<i class="fas fa-trash remove_position" aria-hidden="true" id="button_delete_"></i>' +
							'</div>' +
							'<div class="col-sm-11">' +
								'<div class="form-group {{ $errors->has('sr.*.attended_by') ? 'has-error' : '' }}">' +
									'<select name="sr[' + xs + '][attended_by]" id="staff_id_' + xs + '" class="form-control">' +
										'<option value="">Please choose</option>' +
@foreach($staff as $st)
										'<option value="{!! $st->id !!}">{{ $st->name }}</option>' +
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
	//user click on remove text
	e.preventDefault();
	//var $row = $(this).parent('.rowposition');
	var $row = $(this).parent().parent().parent();
	var $option1 = $row.find('[name="sr[][attended_by]"]');
	$row.remove();

	$('#form').bootstrapValidator('removeField', $option1);
	console.log(xs);
    xs--;
})

/////////////////////////////////////////////////////////////////////////////////////////
// add attendees phone number : add and remove row

var mxfields	= 10; //maximum input boxes allowed
var addBtn	= $(".add_phoneattendees");
var wrapp	= $(".phoneattendees_wrap");

var ix = 1;
$(addBtn).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(ix < mxfields){
		ix++;
		wrapp.append(

					'<div class="rowphoneattendees">' +
						'<div class="form-row col-sm-12">' +
							'<div class="col-sm-1 text-danger">' +
									'<i class="fas fa-trash remove_phoneattendees" aria-hidden="true" id="button_delete_"></i>' +
							'</div>' +
							'<div class="col-sm-11">' +
								'<div class="form-group {{ $errors->has('srp.*.phone_number') ? 'has-error' : '' }}">' +
									'<input type="text" name="srp[' + ix + '][phone_number]" id="phone_attendees_' + ix + '" class="form-control" placeholder="Attendees Phone Number">' +
								'</div>' +
							'</div>' +
						'</div>' +
					'</div>'

		); //add input box

		//bootstrap validate
		$('#form').bootstrapValidator('addField', $('.rowphoneattendees') .find('[name="srp[' + ix + '][phone_number]"]'));
	}
});

$(wrapp).on("click",".remove_phoneattendees", function(e){
	//user click on remove text
	e.preventDefault();
	//var $row = $(this).parent('.rowphoneattendees');
	var $row = $(this).parent().parent().parent();
	var $option1 = $row.find('[name="srp[][phone_number]"]');
	$row.remove();

	$('#form').bootstrapValidator('removeField', $option1);
	console.log(ix);
	ix--;
})

/////////////////////////////////////////////////////////////////////////////////////////
// ajax post delete row attendees
$(document).on('click', '.delete_attendees', function(e){
	var attendId = $(this).data('id');
	SwalDeleteAttend(attendId);
	e.preventDefault();
});

function SwalDeleteAttend(attendId){
	swal.fire({
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
					swal.fire('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_attendees_' + attendId).parent().parent().remove();
				})
				.fail(function(){
					swal.fire('Oops...', 'Something went wrong with ajax !', 'error');
				})
			});
		},
		allowOutsideClick: false			  
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal.fire('Cancelled', 'Your data is safe from delete', 'info')
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
		serial: {
			validators : {
				digits: {
					message: 'The value is not a digits. '
				},
			}
		},
		customer_id: {
			validators : {
				notEmpty: {
					message: 'Please choose. '
				},
			}
		},
		inform_by: {
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

		'srp[{{ $u }}][phone_number]': {
			validators: {
				digits: {
					message: 'The value is not a digits. '
				},
			}
		},
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
		remarks: {
			validators : {
				// notEmpty: {
				// 	message: 'Please choose. '
				// },
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

