@extends('layouts.app')

@section('content')
<?php
ini_set('max_execution_time', 180); //3 minutes
?>
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
			<div class="card-body table-responsive">

				<ul class="nav nav-pills">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('staffOvertime.index') }}">Overtime</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="{{ route('staffAvailability.index') }}">Staff Availability Report</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{!! route('staffDis.index') !!}">Staff Attendance & Discipline</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{!! route('staffDisciplinaryAct.index') !!}">Staff Disciplinary Action</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{!! route('staffResign.index') !!}">Staff Resignation</a>
					</li>
				</ul>

				@include('generalAndAdministrative.hr.staffmanagement.availability.content')

			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$("#username").keyup(function() {
	uch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
//
$('#cat').select2({
	placeholder: 'Please Choose',
	width: '100%',
});

$('#month').select2({
	placeholder: 'Please Choose',
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
	$('#form').bootstrapValidator({
		feedbackIcons: {
			valid: '',
			invalid: '',
			validating: ''
		},
		fields: {
			year: {
				validators : {
					notEmpty: {
						message: 'Please insert year in this format (YYYY). '
					},
					integer: {
						message: 'The value is not an integer. '
					},
					stringLength: {
						min: 4,
						max: 4,
						message: 'The year must exactly 4 digit. '
					}
				}
			},
			category: {
				validators : {
					notEmpty: {
						message: 'Please choose. '
					},
				}
			},
			month: {
				validators : {
					notEmpty: {
						message: 'Please choose. '
					},
				}
			},
		}
	})
	.find('[name="reason"]')
	// .ckeditor()
	// .editor
		.on('change', function() {
			// Revalidate the bio field
		$('#form').bootstrapValidator('revalidateField', 'reason');
		// console.log($('#reason').val());
	});

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

