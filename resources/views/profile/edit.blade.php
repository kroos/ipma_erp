@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1 class="card-title">Profile</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')
{!! Form::model($staff, ['route' => ['staff.update', $staff->id], 'method' => 'PATCH', 'id' => 'form', 'class' => 'form-horizontal', 'autocomplete' => 'off', 'files' => true]) !!}
	@include('profile._form')
{{ Form::close() }}
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$('input, #add').keyup(function() {
	uch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$('#pob').keyup(function() {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
// select 2
$('#stat, #religion, #genderr, #racer, #count, #marstatus').select2({
	placeholder: 'Please Select',
	allowClear: true
});

/////////////////////////////////////////////////////////////////////////////////////////
//datepicker
$('#dobb').datetimepicker({
	// format: 'dddd, YYYY-MM-DD h:mm A',
	 format: 'YYYY-MM-DD',
	// autoclose: true,
	// todayHighlight : true,
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
		image: {
			validators: {
				file: {
					extension: 'jpeg,jpg,png,bmp',
					type: 'image/jpeg,image/png,image/bmp',
					maxSize: 2097152,	// 2048 * 1024,
					message: 'The selected file is not valid. Please use jpeg or png and the image is below than 3MB. '
				},
			}
		},
		id_card_passport: {
			validators: {
				notEmpty: {
					message: 'Sila masukkan no kad pengenalan atau no passport. '
				},
			}
		},
		religion_id: {
			validators: {
				notEmpty: {
					message: 'Sila pilih satu pilihan. '
				},
			}
		},
		gender_id: {
			validators: {
				notEmpty: {
					message: 'Sila pilih satu pilihan. '
				},
			}
		},
		race_id: {
			validators: {
				notEmpty: {
					message: 'Sila pilih satu pilihan. '
				},
			}
		},
		address: {
			validators: {
				notEmpty: {
					message: 'Sila masukkan alamat rumah. '
				},
			}
		},
		pob: {
			validators: {
				notEmpty: {
					message: 'Sila masukkan tempat kelahiran. '
				},
			}
		},
		country_id: {
			validators: {
				notEmpty: {
					message: 'Sila pilih satu pilihan. '
				},
			}
		},
		marital_status_id: {
			validators: {
				notEmpty: {
					message: 'Sila pilih satu pilihan. '
				},
			}
		},
		mobile: {
			validators: {
				notEmpty: {
					message: 'Sila masukkan nombor telefon bimbit. '
				},
				numeric: {
					message: 'Nombor sahaja. '
				},
			}
		},
		phone: {
			validators: {
				stringLength: {
					min: 9,
					max: 10,
					message: 'Sila masukkan nomobor telefon tetap (sekiranya ada).'
				},
				numeric: {
					message: 'Nombor sahaja. '
				},
			}
		},
		dob: {
			validators: {
				notEmpty: {
					message: 'Sila masukkan tarikh lahir anda. '
				},
			}
		},
		cimb_account: {
			validators: {
				notEmpty: 	{
					message: 'Sila masukkan nombor akaun CIMB anda. '
				},
				stringLength: {
					min: 10,
					max: 10,
					message: 'Akaun tidak sah. '
				},
				numeric: {
					message: 'Angka sahaja. '
				},
			}
		},
		epf_no: {
			validators: {
				stringLength: {
					min: 8,
					max: 12,
					message: 'Akaun tidak sah. '
				},
				numeric: {
					message: 'Angka sahaja. '
				}
			}
		},
		income_tax_no: {
			validators: {
				stringLength: {
					min: 8,
					max: 14,
					message: 'Akaun tidak sah. '
				},
				regexp: {	
					regexp: /^[A-Z][A-Z][0-9]+$/i,
					message: 'Masukkan dalam format ini AB12345678901 '
				}
			}
		},

	}
});



@endsection

