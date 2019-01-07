@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1 class="card-title">Change Password</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')
{!! Form::model($login, ['route' => ['login.update', $login->id], 'method' => 'PATCH', 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) !!}
	@include('changepass._edit')
{{ Form::close() }}
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$('#email').keyup(function() {
	lch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
// select 2
$('#stat, #religion, #genderr, #racer, #count, #marstatus, #drivelicense').select2({
	placeholder: 'Please Select',
	allowClear: true,
	width: '100%'
});

/////////////////////////////////////////////////////////////////////////////////////////
//datepicker
// $('#dobb').datetimepicker({
// 	// format: 'dddd, YYYY-MM-DD h:mm A',
// 	 format: 'YYYY-MM-DD',
// 	// autoclose: true,
// 	// todayHighlight : true,
// 	viewMode: 'years',
// })
// .on('dp.change dp.show dp.update', function(e) {
// 	$('#form').bootstrapValidator('revalidateField', 'dob');
// });


/////////////////////////////////////////////////////////////////////////////////////////
// bootstrap validator
$('#form').bootstrapValidator({
	feedbackIcons: {
		valid: '',
		invalid: '',
		validating: ''
	},
	fields: {
		oldPassword: {
			validators: {
				notEmpty: {
					message: 'Please insert current password. '
				},
			}
		},
		newPassword: {
			validators: {
				notEmpty: {
					message: 'Please insert new password. '
				},
				identical: {
					field: 'newPassword_confirmation',
					message: 'The password and its confirm are not the same'
				},
			}
		},
		newPassword_confirmation: {
			validators: {
				notEmpty: {
					message: 'Please insert new password again. '
				},
				identical: {
					field: 'newPassword',
					message: 'The password and its confirm are not the same'
				},
			}
		},

	}
});



@endsection

