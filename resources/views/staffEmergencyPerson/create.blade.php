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
// datetime for the 1st one

$('#dob_1').datetimepicker({
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

		children: {
			validators: {
				notEmpty: {
					message: 'Sila masukkan nama saudara. '
				},
				regexp: {
					regexp: /^[a-z\s\'\@]+$/i,
					message: 'The full name can consist of alphabetical characters, \', @ and spaces only'
				},
			}
		},
		dob: {
			validators: {
				date: {
					format: 'YYYY-MM-DD',
					message: 'The value is not a valid date. '
				},
			}
		},
		gender_id: {
			validators: {
				notEmpty: {
					message: 'Sila pilih jantina anak. '
				},
			}
		},
		education_level_id: {
			validators: {
				notEmpty: {
					message: 'Sila pilih tahap pengajian anak. '
				},
			}
		},
		health_status_id: {
			validators: {
				notEmpty: {
					message: 'Sila pilih tahap kesihatan anak. '
				},
			}
		},

	}
});


/////////////////////////////////////////////////////////////////////////////////////////
//select2
$('#gen').select2({
	placeholder: 'Jantina'
});

$('#edulevel').select2({
	placeholder: 'Tahap Pelajaran'
});

$('#healthStat').select2({
	placeholder: 'Tahap Kesihatan'
});

$('#taxExempPercent').select2({
	placeholder: 'Peratus Pengecualian Cukai'
});


/////////////////////////////////////////////////////////////////////////////////////////
//show/hide input
$('#hidden').hide();
$('#te').change(function() {
	if ($('#te').is(':checked')) {
		$('#hidden').show(1000);
	}else{
		$('#hidden').hide(1000);
	}
});


/////////////////////////////////////////////////////////////////////////////////////////
//add more row


/////////////////////////////////////////////////////////////////////////////////////////
@endsection

