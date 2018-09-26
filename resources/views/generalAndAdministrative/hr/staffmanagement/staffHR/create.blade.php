@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Add Staff</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

{!! Form::open(['route' => ['staffHR.store'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) !!}
	@include('generalAndAdministrative.hr.staffmanagement.staffHR._form')
{{ Form::close() }}
		
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$(document).on('keyup', '#hol ', function () {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
//select2
$('#gid').select2({
	placeholder: 'Please choose',
	ajax: {
		url: '{{ route('workinghour.gender') }}',
		data: { '_token': '{!! csrf_token() !!}' },
		type: 'POST',
		dataType: 'json',
	},
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
//select2
$('#sid').select2({
	placeholder: 'Please choose',
	ajax: {
		url: '{{ route('workinghour.statusstaff') }}',
		data: { '_token': '{!! csrf_token() !!}' },
		type: 'POST',
		dataType: 'json',
	},
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
})
.on('select2:select', function (e) {
	var data = e.params.data;
	// console.log(data.code);
	$('#uid').val(data.code);
});

/////////////////////////////////////////////////////////////////////////////////////////
//select2
$('#lid').select2({
	placeholder: 'Please choose',
	ajax: {
		url: '{{ route('workinghour.location') }}',
		data: { '_token': '{!! csrf_token() !!}' },
		type: 'POST',
		dataType: 'json',
	},
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
// jquery chained
$('#deptid').remoteChained({
	parents: '#divid',
	url : "{{ route('workinghour.department') }}"
});

$('#deptid1').remoteChained({
	parents: '#divid1',
	url : "{{ route('workinghour.department') }}"
});

/////////////////////////////////////////////////////////////////////////////////////////
// jquery chained
$('#posid').remoteChained({
	parents: '#deptid',
	url : "{{ route('workinghour.position') }}"
});

$('#posid1').remoteChained({
	parents: '#deptid1',
	url : "{{ route('workinghour.position') }}"
});

/////////////////////////////////////////////////////////////////////////////////////////
//select2
$('#divid,#divid1').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
//select2
$('#deptid,#deptid1').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
//select2
$('#posid,#posid1').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
// join date
$('#jdate').datetimepicker({
	format:'YYYY-MM-DD',
	useCurrent: false,
})
.on('dp.change dp.show dp.update', function() {
	$('#form').bootstrapValidator('revalidateField', 'join_date');
});

/////////////////////////////////////////////////////////////////////////////////////////
// dob
$('#dob').datetimepicker({
	format:'YYYY-MM-DD',
	viewMode: 'years',
	useCurrent: false,
})
.on('dp.change dp.show dp.update', function() {
	$('#form').bootstrapValidator('revalidateField', 'dob');
});

/////////////////////////////////////////////////////////////////////////////////////////
// validator
$(document).ready(function() {
	$('#form').bootstrapValidator({
		feedbackIcons: {
			valid: '',
			invalid: '',
			validating: ''
		},
		fields: {
			name: {
				validators : {
					notEmpty: {
						message: 'Please insert name. '
					},
				}
			},
			status_id: {
				validators : {
					notEmpty: {
						message: 'Please choose. '
					},
				}
			},
			username: {
				validators : {
					notEmpty: {
						message: 'Please insert name'
					},
					remote: {
						type: 'POST',
						url: '{{ route('workinghour.loginuser') }}',
						message: 'This ID is already exist. Please use another ID. ',
						data: function(validator) {
									return {
												_token: '{!! csrf_token() !!}',
												username: $('#uid').val(),
									};
								},
						delay: 1,		// wait 0.001 seconds
					}
				}
			},
			password: {
				validators : {
					notEmpty: {
						message: 'Please insert password. '
					},
				}
			},
			join_date: {
				validators: {
					notEmpty: {
						message: 'Please insert join date. '
					},
					date: {
						format: 'YYYY-MM-DD',
						message: 'The value is not a valid date. '
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
			location_id: {
				validators : {
					notEmpty: {
						message: 'Please choose. '
					},
				}
			},
			division_id: {
				validators : {
					notEmpty: {
						message: 'Please choose. '
					},
				}
			},
			department_id: {
				validators : {
					notEmpty: {
						message: 'Please choose. '
					},
				}
			},
			position_id: {
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
	})
	;
});

/////////////////////////////////////////////////////////////////////////////////////////


@endsection

