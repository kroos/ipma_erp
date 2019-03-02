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
			<div class="card-body table-responsive">

				<ul class="nav nav-pills">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('staffOvertime.index') }}">Overtime</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('staffAvailability.index') }}">Staff Availability Report</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{!! route('staffDis.index') !!}">Staff Attendance & Discipline</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{!! route('staffDisciplinaryAct.index') !!}">Staff Disciplinary Action</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="{!! route('staffResign.index') !!}">Staff Resignation</a>
					</li>
				</ul>

{{ Form::model($staffResign, ['route' => ['staffResign.update', $staffResign->id], 'method' => 'PATCH', 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) }}
				@include('generalAndAdministrative.hr.staffmanagement.resign._edit')
{!! Form::close() !!}

			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// table
// $.fn.dataTable.moment( 'ddd, D MMM YYYY' );
$("#staff1, #staff2").DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[3, "asc" ]],	// sorting the 4th column descending
	// responsive: true,
});

$('#staff1').colResizable({liveDrag:true});

/////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////
// date
	$('#datl').datetimepicker({
		format:'YYYY-MM-DD',
		// useCurrent: false,
	})
	.on('dp.change dp.show dp.update', function(e) {
		$('#form').bootstrapValidator('revalidateField', 'resignation_letter_at');
	})

	$('#datr').datetimepicker({
		format:'YYYY-MM-DD',
		// useCurrent: false,
	})
	.on('dp.change dp.show dp.update', function(e) {
		$('#form').bootstrapValidator('revalidateField', 'resign_at');
	});

/////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////
// validator
$(document).ready(function() {
	$('#form').bootstrapValidator({
		feedbackIcons: {
			valid: '',
			invalid: '',
			validating: ''
		},
		fields: {
			resignation_letter_at: {
				validators: {
					notEmpty : {
						message: 'Please insert date. '
					},
					date: {
						format: 'YYYY-MM-DD',
						message: 'The value is not a valid date. '
					},
				}
			},
			resign_at: {
				validators: {
					notEmpty : {
						message: 'Please insert date. '
					},
					date: {
						format: 'YYYY-MM-DD',
						message: 'The value is not a valid date. '
					},
				}
			},
		}
	})
	// .find('[name="reason"]')
	// .ckeditor()
	// .editor
	// 	.on('change', function() {
	// 		// Revalidate the bio field
	// 	$('#form').bootstrapValidator('revalidateField', 'reason');
	// 	// console.log($('#reason').val());
	// })
	;
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
@endsection
