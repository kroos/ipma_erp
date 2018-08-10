@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Emergency Contact Person</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

{!! Form::open(['route' => ['staffEmergencyPerson.store'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) !!}
	@include('staffEmergencyPerson._form')
{{ Form::close() }}
		
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$(document).on('keyup', 'input', function () {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$(document).on('keyup', '#dob', function () {
	uch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
// add emergency contact person : add and remove row

var max_fields      = 4; //maximum input boxes allowed
var add_buttons	= $(".add_emerg_person");
var wrappers	= $(".emerg_person_wrap");

var xs = 1;
$(add_buttons).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(xs < max_fields){
		xs++;
		wrappers.append(
						'<div class="rowemerg_person">' +
							'<div class="row col-sm-12">' +
								'<div class="col-sm-1">' +
									'<button class="btn btn-danger remove_emerg_person" type="button">' +
										'<i class="fas fa-trash" aria-hidden="true"></i>' +
									'</button>' +
								'</div>' +
								'<div class="col-sm-11">' +
									'<div class="form-group {{ $errors->has('emerg.*.phone') ? 'has-error' : '' }}">' +
										'<input type="text" name="emerg[' + xs + '][phone]" value="" class="form-control" id="phone" placeholder="Telefon" autocomplete="off">' +
									'</div>' +
								'</div>' +
							'</div>' +
						'</div>'
		); //add input box
	
		//bootstrap validate
		$('#form').bootstrapValidator('addField',	$('.rowemerg_person')	.find('[name="emerg['+ xs +'][phone]"]'));
	}})

$(wrappers).on("click",".remove_emerg_person", function(e){
	//user click on remove text
	e.preventDefault();
	//var $row = $(this).parent().parent('.rowemerg_person');
	var $row = $(this).parent().parent();

	var $option1 = $row.find('[name="emerg[' + xs + '][phone]"]');
	$row.remove();

	$('#form').bootstrapValidator('removeField', $option1);
    xs--;
})

/////////////////////////////////////////////////////////////////////////////////////////
// bootstrap validator
$('#form').bootstrapValidator({
	feedbackIcons: {
		valid: '',
		invalid: '',
		validating: ''
	},
	fields: {

		contact_person: {
			validators: {
				notEmpty: {
					message: 'Sila masukkan nama orang untuk dihubungi. '
				},
				regexp: {
					regexp: /^[a-z\s\'\@]+$/i,
					message: 'The full name can consist of alphabetical characters, \', @ and spaces only'
				},
			}
		},
		relationship: {
			validators: {
				notEmpty: {
					message: 'Sila masukkan hubungan anda dengan penama diatas. '
				},
			}
		},
		address: {
			validators: {
				notEmpty: {
					message: 'Sila masukkan alamat. '
				},
			}
		},

@for($i=1; $i < 5; $i++)
		'emerg[{{ $i }}][phone]': {
			validators: {
				notEmpty: {
					message: 'Sila masukkan nombor telefon. '
				},
				regexp: {
					regexp: /^(\+?6?01)[0|1|2|3|4|6|7|8|9]\-*[0-9]{7,8}$/,
					message: 'Please insert your valid phone number'
				},
				remote: {
					type: 'POST',
					url: '{{ route('staffEmergencyPersonPhone.search') }}',
					message: 'Phone number already exist.',
					data: function(validator) {
								return {
											_token: '{!! csrf_token() !!}',
								};
							},
					delay: 1,		// wait 0.001 seconds
				},
			}
		},
@endfor

	}
});


/////////////////////////////////////////////////////////////////////////////////////////
//add more row


/////////////////////////////////////////////////////////////////////////////////////////
@endsection

