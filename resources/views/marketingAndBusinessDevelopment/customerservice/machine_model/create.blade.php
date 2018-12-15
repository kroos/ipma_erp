@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Customer</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

{!! Form::open(['route' => ['machine_model.store', 'id='.$_GET['id']], 'id' => 'form', 'class' => 'form-horizontal', 'autocomplete' => 'off', 'files' => true]) !!}
	@include('marketingAndBusinessDevelopment.customerservice.machine_model._create')
{{ Form::close() }}
		
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$(document).on('keyup', 'input', function () {
	uch(this);
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
		model: {
			validators: {
				notEmpty: {
					message: 'Machne model name is required. '
				},
			}
		},
	}
});
@endsection

