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
				{{ Form::open(['route' => ['staffAnnualMCLeave.store'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true, 'autocomplete' => 'off', 'files' => true]) }}
				@include('generalAndAdministrative.hr.leave.settings._create')
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
// select 2
$('#sid').select2({
	width: '100%',
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
});

/////////////////////////////////////////////////////////////////////////////////////////
$('#form').bootstrapValidator({
	feedbackIcons: {
		valid: '',
		invalid: '',
		validating: ''
	},
	fields: {
		staff_id: {
			validators: {
				notEmpty: {
					message: 'Please choose. ',
				}
			}
		},
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
	}
})
//	.find('[name="remarks"]')
//	.ckeditor()
//	.editor
//		.on('change', function() {
//		// Revalidate the remarks field
//		$('#form').bootstrapValidator('revalidateField', 'remarks');
//	})
;

/////////////////////////////////////////////////////////////////////////////////////////
// generate almcml for next year
$(document).on('click', '.delete_almcml', function(e){
	
	var almcml_id = $(this).data('id');
	SwalDelete(almcml_id);
	e.preventDefault();
});

function SwalDelete(almcml_id){
	swal({
		title: 'Are you sure?',
		text: "It will be deleted permanently!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					type: 'DELETE',
					url: '{{ url('staffAnnualMCLeave') }}' + '/' + almcml_id,
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: almcml_id,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_nrl_' + almcml_id).parent().parent().remove();
				})
				.fail(function(){
					swal('Oops...', 'Something went wrong with ajax !', 'error');
				})
			});
		},
		allowOutsideClick: false			  
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal('Cancelled', 'Your data is safe from delete', 'info')
		}
	});
}

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

