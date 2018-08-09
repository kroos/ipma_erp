@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Edit Sibling</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

{!! Form::model($staffSibling, ['route' => ['staffSibling.update', $staffSibling->id], 'method' => 'PATCH', 'id' => 'form', 'class' => 'form-horizontal', 'autocomplete' => 'off', 'files' => true]) !!}
	@include('staffSibling._form_edit')
{{ Form::close() }}


		
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// ucwords
$(document).on('keyup', 'input', function () {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
// datetime for the 1st one

$('#dob').datetimepicker({
	format:'YYYY-MM-DD',
	viewMode: 'years',
})
.on('dp.change dp.show dp.update', function(e) {
	$('#form').bootstrapValidator('revalidateField', 'dob');
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

		'spouse': {
			validators: {
				notEmpty: {
					message: 'Sila masukkan nama saudara kandung. '
				},
				regexp: {
					regexp: /^[a-z\s\'\@]+$/i,
					message: 'The full name can consist of alphabetical characters, \', @ and spaces only'
				},
			}
		},
		'phone': {
			validators: {
				notEmpty: {
					message: 'Sila masukkan no telefon bimbit. '
				},
				numeric: {
					message: 'Hanya angka sahaja. '
				},
			}
		},
		'dob': {
			validators: {
				date: {
					format: 'YYYY-MM-DD',
					message: 'The value is not a valid date. '
				},
			}
		},
		'profession': {
			validators: {
				notEmpty: {
					message: 'Sila masukkan pekerjaan pasangan anda. '
				},
			}
		},
	}
});

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

