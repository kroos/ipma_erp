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
				<a class="nav-link" href="{{ route('leaveEditing.index') }}">Leave</a>
			</li>
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('tcms.index') }}">TCMS</a>
			</li>
		</ul>

		<div class="card">
			<div class="card-header">Edit Attendance</div>
			<div class="card-body">

		@include('layouts.info')
		@include('layouts.errorform')

<?php
$staffTCMS = \App\Model\StaffTCMS::where([
			['staff_id', $staff_id],
			['date', $date]
])->first();
?>

{{ Form::model( $staffTCMS, ['route' => ['staffTCMS.update', $staff_id, '&date='.$date], 'method' => 'PATCH', 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) }}
	@include('generalAndAdministrative.hr.tcms._edit')
</form>
		
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$(document).on('keyup', '#hol ', function () {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
//select2
$('#lt').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
// time start
$('#in').datetimepicker({
	format: 'h:mm A',
	// enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
})
.on('dp.change dp.show dp.update', function(e){
	$('#form').bootstrapValidator('revalidateField', 'in');
});

$('#break').datetimepicker({
	format: 'h:mm A',
	// enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
})
.on('dp.change dp.show dp.update', function(e){
	$('#form').bootstrapValidator('revalidateField', 'break');
});

$('#resume').datetimepicker({
	format: 'h:mm A',
	// enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
})
.on('dp.change dp.show dp.update', function(e){
	$('#form').bootstrapValidator('revalidateField', 'resume');
});

$('#out').datetimepicker({
	format: 'h:mm A',
	// enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
})
.on('dp.change dp.show dp.update', function(e){
	$('#form').bootstrapValidator('revalidateField', 'out');
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
			in: {
				validators: {
//					notEmpty: {
//						message: 'Please insert time in. '
//					},
				}
			},
			break: {
				validators: {
//					notEmpty: {
//						message: 'Please insert time break. '
//					},
				}
			},
			resume: {
				validators: {
//					notEmpty: {
//						message: 'Please insert time resume. '
//					},
				}
			},
			out: {
				validators: {
//					notEmpty: {
//						message: 'Please insert time out. '
//					},
				}
			},
		}
	})
	// .find('[name="reason"]')
	// .ckeditor()
	// .editor
	//	.on('change', function() {
			// Revalidate the bio field
	//	$('#form').bootstrapValidator('revalidateField', 'reason');
		// console.log($('#reason').val());
	// })
	;

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

