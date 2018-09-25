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
$(document).on('keyup', '#hol', function () {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

