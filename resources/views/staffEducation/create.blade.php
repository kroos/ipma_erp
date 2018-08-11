@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Pengajian</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

{!! Form::open(['route' => ['staffEducation.store'], 'id' => 'form', 'class' => 'form-horizontal', 'autocomplete' => 'off', 'files' => true]) !!}
	@include('staffEducation._form')
{{ Form::close() }}
		
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$(document).on('keyup', '#npasa', function () {
	tch(this);
});

$(document).on('keyup', '#qua', function () {
	uch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
// datetime for the 1st one
$('#from').datetimepicker({
	format:'YYYY-MM-DD',
	viewMode: 'years',
})
.on('dp.change dp.show dp.update', function(e) {
	$('#form').bootstrapValidator('revalidateField', 'from');
	var minDate = $('#from').val();
	$('#to').datetimepicker('minDate', minDate);
});

$('#to').datetimepicker({
	format:'YYYY-MM-DD',
	viewMode: 'years',
})
.on('dp.change dp.show dp.update', function(e) {
	$('#form').bootstrapValidator('revalidateField', 'to');
	var maxDate = $('#to').val();
	$('#from').datetimepicker('maxDate', maxDate);
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

		institution: {
			validators: {
				notEmpty: {
					message: 'Sila masukkan pusat pengajian (sekolah/maktab/universiti). '
				},
			}
		},
		from: {
			validators: {
				date: {
					format: 'YYYY-MM-DD',
					message: 'The value is not a valid date'
				},
			}
		},
		to: {
			validators: {
				date: {
					format: 'YYYY-MM-DD',
					message: 'The value is not a valid date'
				},
			}
		},
		qualification: {
			validators: {
				notEmpty: {
					message: 'Sila masukkan kelulusan tertinggi di tempat tersebut. '
				},
			}
		},

	}
});

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

