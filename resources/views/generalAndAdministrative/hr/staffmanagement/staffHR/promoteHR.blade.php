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

		<dl class="row">
			<dt class="col-sm-3"><h5 class="">Note :</h5></dt>
			<dd class="col-sm-9">
				<p>Please note that the password is the same as before, they can change it themself at <strong>"Profile"</strong> section.</p>
			</dd>
		</dl>

		@include('layouts.info')
		@include('layouts.errorform')

{{ Form::model( $staffHR, ['route' => ['staffHR.promoteupdateHR', $staffHR->id], 'method' => 'PATCH', 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) }}
	@include('generalAndAdministrative.hr.staffmanagement.staffHR._form_promote_HR')
{{ Form::close() }}
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$(document).on('keyup', '#username ', function () {
	uch(this);
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
			username: {
				validators: {
					notEmpty: {
						message: 'Please insert Staff ID. '
					},
					remote: {
						type: 'POST',
						url: '{{ route('workinghour.loginuser') }}',
						message: 'This ID is already exist. Please use another ID. ',
						data: function(validator) {
									return {
												_token: '{!! csrf_token() !!}',
												username: $('#username').val(),
									};
								},
						delay: 1,		// wait 0.001 seconds
					},
					stringLength: {
						min: 5,
						max: 6,
						message: 'The Staff ID must be between 5 to 6 characters long. '
					},
				}
			},
			annual_leave: {
				validators: {
					notEmpty: {
						message: 'Please insert annual leave. '
					},
					numeric: {
						message: 'Only number. '
					}
				}
			},
			medical_leave: {
				validators: {
					notEmpty: {
						message: 'Please insert medical leave. '
					},
					numeric: {
						message: 'Only number. '
					}
				}
			},
		}
	})
	// .find('[name="reason"]')
	// .ckeditor()
	// .editor
	//	.on('change', function() {
		// Revalidate the bio field
	//	$('#form').bootstrapValidator('revalidateField', 'reason');
	//	console.log($('#reason').val());
	// })
	;
});

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

