@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Human Resource Department</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<ul class="nav nav-tabs">
@foreach( App\Model\Division::find(1)->hasmanydepartment()->whereNotIn('id', [22, 23, 24])->get() as $key)
			<li class="nav-item">
				<a class="nav-link {{ ($key->id == 3)? 'active' : 'disabled' }}" href="{{ route("$key->route.index") }}">{{ $key->department }}</a>
			</li>
@endforeach
		</ul>

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link " href="{{ route('hrSettings.index') }}">Settings</a>
			</li>
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('staffManagement.index') }}">Staff Management</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('leaveEditing.index') }}">Leave</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('tcms.index') }}">TCMS</a>
			</li>
		</ul>

		<div class="card">
			<div class="card-header">Staff Management</div>
			<div class="card-body">

		@include('layouts.info')
		@include('layouts.errorform')

{{ Form::model( $staffHR, ['route' => ['staffHR.update', $staffHR->id], 'method' => 'PATCH', 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) }}
	@include('generalAndAdministrative.hr.staffmanagement.staffHR._form_edit')
{{ Form::close() }}
		
			</div>
		</div>
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
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
//select2
$('#lid').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
// jquery chained
$('#deptid').chainedTo('#divid');

/////////////////////////////////////////////////////////////////////////////////////////
// jquery chained
$('#posid').chainedTo('#deptid');

/////////////////////////////////////////////////////////////////////////////////////////
//select2
$('#divid').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
//select2
$('#deptid').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
//select2
$('#posid').select2({
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
// validator
$(document).ready(function() {
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
			name: {
				validators : {
					notEmpty: {
						message: 'Please insert name. '
					},
				}
			},
			gender_id: {
				validators : {
					notEmpty: {
						message: 'Please choose. '
					},
				}
			},
			join_at: {
				validators: {
//					notEmpty: {
//						message: 'Please insert join date. '
//					},
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

