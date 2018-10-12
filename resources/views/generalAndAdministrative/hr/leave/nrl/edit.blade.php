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
				<a class="nav-link" href="{{ route('staffManagement.index') }}">Staff Management</a>
			</li>
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('leaveEditing.index') }}">Leave</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('tcms.index') }}">TCMS</a>
			</li>
		</ul>

		<div class="card">
			<div class="card-header">Leaves Management</div>
			<div class="card-body">
				{{ Form::model( $staffLeaveReplacement, ['route' => ['staffLeaveReplacement.update', $staffLeaveReplacement->id], 'method' => 'PATCH', 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) }}
					@include('generalAndAdministrative.hr.leave.nrl._edit')
				{{ Form::close() }}
			</div>
		</div>

	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// date time start
$('#wd').datetimepicker({
	format: 'YYYY-MM-DD',
	useCurrent: false,
})
.on('dp.change dp.show dp.update', function(e) {
	$('#form').bootstrapValidator('revalidateField', 'working_date');
});

/////////////////////////////////////////////////////////////////////////////////////////
// ucwords
$(document).on('keyup', '#remarks', function () {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
// bootstrap validator
$(document).ready(function() {
	$('#form').bootstrapValidator({
		feedbackIcons: {
			valid: '',
			invalid: '',
			validating: ''
		},
		fields: {
			working_date: {
				validators: {
					notEmpty: {
						message: 'Please insert working date. '
					},
					date: {
						format: 'YYYY-MM-DD',
						message: 'The value is not a valid date. '
					},
				}
			},
			working_location: {
				validators: {
					notEmpty: {
						message: 'Please insert working location. '
					}
				}
			},
			working_reason: {
				validators: {
					notEmpty: {
						message: 'Please insert working reason. '
					}
				}
			},
			leave_total: {
				validators: {
					notEmpty: {
						message: 'Please insert working reason. '
					},
					numeric: {
						separator: '.',
						message: 'Please insert numbers. '
					},
				}
			},
			leave_utilize: {
				validators: {
					notEmpty: {
						message: 'Please insert working reason. '
					},
					numeric: {
						separator: '.',
						message: 'Please insert numbers. '
					},
				}
			},
			leave_balance: {
				validators: {
					notEmpty: {
						message: 'Please insert working reason. '
					},
					numeric: {
						separator: '.',
						message: 'Please insert numbers. '
					},
				}
			},
			remarks: {
				notEmpty: {
					message: 'Please insert reamrks. '
				}
			},
		}
	})
	.find('[name="remarks"]')
	.ckeditor()
	.editor
		.on('change', function() {
		// Revalidate the remarks field
		$('#form').bootstrapValidator('revalidateField', 'remarks');
		console.log($('#remarks').val());
	});
});	
/////////////////////////////////////////////////////////////////////////////////////////
@endsection

