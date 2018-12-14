@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Customer</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

{!! Form::open(['route' => ['customer.store', 'id='.$_GET['id']], 'id' => 'form', 'class' => 'form-horizontal', 'autocomplete' => 'off', 'files' => true]) !!}
	@include('customer._create')
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
// bootstrap validator

$('#form').bootstrapValidator({
	feedbackIcons: {
		valid: '',
		invalid: '',
		validating: ''
	},
	fields: {
		customer: {
			validators: {
				notEmpty: {
					message: 'Customer name is required. '
				},
			}
		},
		pc: {
			validators: {
				notEmpty: {
					message: 'Please insert this field. '
				},
			}
		},
		address1: {
			validators: {
				notEmpty: {
					message: 'Please insert this field. '
				},
			}
		},
		address2: {
			validators: {
				notEmpty: {
					message: 'Please insert this field. '
				},
			}
		},
		phone: {
			validators: {
				notEmpty: {
					message: 'Please insert this field. '
				},
				digits: {
					message: 'Only numbers. '
				},
			}
		},
		fax: {
			validators: {
				digits: {
					message: 'Only numbers. '
				},
			}
		},
	}
});
@endsection

