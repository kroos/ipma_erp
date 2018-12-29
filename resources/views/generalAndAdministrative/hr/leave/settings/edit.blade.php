@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Human Resource Department</h1></div>
	<div class="card-body">

		<ul class="nav nav-tabs">
@foreach( App\Model\Division::find(1)->hasmanydepartment()->whereNotIn('id', [22, 23, 24])->get() as $key)
			<li class="nav-item">
				<a class="nav-link {{ ($key->id == 3)? 'active' : 'disabled' }}" href="{{ route("$key->route.index") }}">{{ $key->department }}</a>
			</li>
@endforeach
		</ul>

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('hrSettings.index') }}">Settings</a>
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
				{{ Form::model( $staffAnnualMCLeave, ['route' => ['staffAnnualMCLeave.update', $staffAnnualMCLeave->id], 'method' => 'PATCH', 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) }}
				@include('generalAndAdministrative.hr.leave.settings._edit')
				{!! Form::close() !!}
			</div>
		</div>

	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$("#rem").keyup(function() {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
// auto for balance
$(document).on('keyup', '#al', function () {
	$('#alb').val( $(this).val() );
});

// auto for balance
$(document).on('keyup', '#mc', function () {
	$('#mcb').val( $(this).val() );
});

// auto for balance
$(document).on('keyup', '#ml', function () {
	$('#mlb').val( $(this).val() );
});

/////////////////////////////////////////////////////////////////////////////////////////
$('#form').bootstrapValidator({
	feedbackIcons: {
		valid: '',
		invalid: '',
		validating: ''
	},
	fields: {
		annual_leave: {
			validators: {
				notEmpty: {
					message: 'Please insert annual leave. '
				},
				numeric: {
					separator: '.',
					message: 'Please insert numbers. '
				},
			}
		},
		annual_leave_adjustment: {
			validators: {
				notEmpty: {
					message: 'Please insert annual leave. '
				},
				numeric: {
					separator: '.',
					message: 'Please insert numbers. '
				},
			}
		},
		annual_leave_balance: {
			validators: {
				notEmpty: {
					message: 'Please insert annual leave. '
				},
				numeric: {
					separator: '.',
					message: 'Please insert numbers. '
				},
			}
		},
		medical_leave: {
			validators: {
				notEmpty: {
					message: 'Please insert annual leave. '
				},
				numeric: {
					separator: '.',
					message: 'Please insert numbers. '
				},
			}
		},
		medical_leave_adjustment: {
			validators: {
				notEmpty: {
					message: 'Please insert medical leave adjustment. '
				},
				numeric: {
					separator: '.',
					message: 'Please insert numbers. '
				},
			}
		},
		medical_leave_balance: {
			validators: {
				notEmpty: {
					message: 'Please insert medical leave balance. '
				},
				numeric: {
					separator: '.',
					message: 'Please insert numbers. '
				},
			}
		},
@if( $staffAnnualMCLeave->belomgtostaff->gender_id == 2 )
		maternity_leave: {
			validators: {
				notEmpty: {
					message: 'Please insert medical leave balance. '
				},
				numeric: {
					separator: '.',
					message: 'Please insert numbers. '
				},
			}
		},
		maternity_leave_balance: {
			validators: {
				notEmpty: {
					message: 'Please insert medical leave balance. '
				},
				numeric: {
					separator: '.',
					message: 'Please insert numbers. '
				},
			}
		},
@endif
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

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

