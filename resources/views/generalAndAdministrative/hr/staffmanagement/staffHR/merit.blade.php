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

				<ul class="nav nav-pills">
					<li class="nav-item">
						<a class="nav-link active" href="{{ route('staffHR.merit', $staffHR->id) }}">Discipline</a>
					</li>
				</ul>

		@include('layouts.info')
		@include('layouts.errorform')

{!! Form::model($staffHR, ['route' => ['staffHR.meritstore', $staffHR->id], 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) !!}
	@include('generalAndAdministrative.hr.staffmanagement.staffHR._merit')
{{ Form::close() }}

			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$(document).on('keyup', '#rem ', function () {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
//select2
$('#sid').select2({
	placeholder: 'Please choose',
	ajax: {
		url: '{{ route('workinghour.discipline') }}',
		data: { '_token': '{!! csrf_token() !!}' },
		type: 'GET',
		dataType: 'json',
	},
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
// validator
$('#form').bootstrapValidator({
	feedbackIcons: {
		valid: '',
		invalid: '',
		validating: ''
	},
	fields: {
		discipline_id: {
			validators : {
				notEmpty: {
					message: 'Please choose. '
				},
			}
		},
		remarks: {
			validators : {
				notEmpty: {
					message: 'Please insert some remarks. '
				},
			}
		},
	}
});

/////////////////////////////////////////////////////////////////////////////////////////


@endsection

