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
				<a class="nav-link" href="{{ route('leaveEditing.index') }}">Leave</a>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="{{ route('tcms.index') }}">TCMS</a>
			</li>
		</ul>

<div class="card">
	<div class="card-header">Human Resource Settings</div>
	<div class="card-body">












<div class="card">
	<div class="card-header">Add Working Hour</div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

{!! Form::open(['route' => ['workingHour.store'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) !!}
	@include('workinghour._form')
{{ Form::close() }}
		
	</div>
</div>











	</div>
</div>
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
//date
$('#effective_date_start').datetimepicker({
	format: 'YYYY-MM-DD'
})
.on("dp.change dp.show dp.update", function (e) {
	var minDate = $('#effective_date_start').val();
	$('#effective_date_end').datetimepicker('minDate', minDate);
	$('#form').bootstrapValidator('revalidateField', 'effective_date_start');
});


$('#effective_date_end').datetimepicker({
	format: 'YYYY-MM-DD',
	useCurrent: false //Important! See issue #1075
})
.on("dp.change dp.show dp.update", function (e) {
	var maxDate = $('#effective_date_end').val();
	$('#effective_date_start').datetimepicker('maxDate', maxDate);
	$('#form').bootstrapValidator('revalidateField', 'effective_date_end');
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
		'effective_date_start': {
			validators: {
				notEmpty: {
					message: 'Please insert date ramadhan start. '
				},
				date: {
					format: 'YYYY-MM-DD',
					message: 'Please insert date ramadhan start. '
				},
				remote: {
					type: 'POST',
					url: '{{ route('workinghour.yearworkinghour1') }}',
					message: 'The duration of Ramadhan month for this year is already exist. Please choose another year',
					data: function(validator) {
								return {
											_token: '{!! csrf_token() !!}',
											effective_date_start: $('#effective_date_start').val(),
								};
							},
					//delay: 1,		// wait 0.001 seconds
				},
			}
		},
		'effective_date_end': {
			validators: {
				notEmpty: {
					message: 'Please insert date ramadhan end. '
				},
				date: {
					format: 'YYYY-MM-DD',
					message: 'Please insert date ramadhan end. '
				},
				remote: {
					type: 'POST',
					url: '{{ route('workinghour.yearworkinghour2') }}',
					message: 'The duration of Ramadhan month for this year is already exist. Please choose another year',
					data: function(validator) {
								return {
											_token: '{!! csrf_token() !!}',
											effective_date_start: $('#effective_date_end').val(),
								};
							},
					delay: 1,		// wait 0.001 seconds
				},
			}
		},
	}
});

/////////////////////////////////////////////////////////////////////////////////////////
//add more row


/////////////////////////////////////////////////////////////////////////////////////////
@endsection

