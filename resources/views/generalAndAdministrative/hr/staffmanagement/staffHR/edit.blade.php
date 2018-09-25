@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Add Holiday Calendar</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

{{ Form::model( $staff, ['route' => ['staffHR.update', $staff->id], 'method' => 'PATCH', 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) }}
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
@endsection

