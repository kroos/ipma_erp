@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Edit Emergency Contact Person Phone</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

{{ Form::model( $staffEmergencyPersonPhone, ['route' => ['staffEmergencyPersonPhone.update', $staffEmergencyPersonPhone->id], 'method' => 'PATCH', 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) }}
	@include('staffEmergencyPersonPhone._form')
{{ Form::close() }}


		
	</div>
</div>
@endsection

@section('js')/////////////////////////////////////////////////////////////////////////////////////////
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
// bootstrap validator
$('#form').bootstrapValidator({
	feedbackIcons: {
		valid: '',
		invalid: '',
		validating: ''
	},
	fields: {

		'phone': {
			validators: {
				notEmpty: {
					message: 'Sila masukkan nombor telefon. '
				},
				regexp: {
					regexp: /^(\+?6?01)[0|1|2|3|4|6|7|8|9]\-*[0-9]{7,8}$/,
					message: 'Please insert your valid phone number'
				},
			}
		},
	}
});

/////////////////////////////////////////////////////////////////////////////////////////
@endsection