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

				@include('generalAndAdministrative.hr.staffmanagement.resign._index')

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
@foreach(\App\Model\Staff::where('active', 1)->whereNotIn('id', ['191', '192'])->get() AS $st)
	$('#rla_{!! $st->id !!}').datetimepicker({
		format:'YYYY-MM-DD',
		// useCurrent: false,
	})
	// .on('dp.change dp.show dp.update', function(e) {
	// 	$('#form').bootstrapValidator('revalidateField', 'resignation_letter_at');
	// })
	;
	$('#ra_{!! $st->id !!}').datetimepicker({
		format:'YYYY-MM-DD',
		// useCurrent: false,
	})
	// .on('dp.change dp.show dp.update', function(e) {
	// 	$('#form').bootstrapValidator('revalidateField', 'resign_at');
	// })
	;
@endforeach
/////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////
// ajax delete
$(document).on('click', '.remove_staffDiscAct', function(e){
	var tdsid = $(this).data('id');
	SwalToggle(tdsid);
	e.preventDefault();
});

function SwalToggle(tdsid){
	swal({
		title: 'Delete Warning',
		text: 'Delete this action?',
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Delete',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: '{{ url('staffDisciplinaryAct') }}' + '/' + tdsid,
					type: 'DELETE',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: tdsid,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Delete Success!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_logistic_' + tdsid).parent().parent().remove();
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
			swal('Cancelled', 'Your data is saved', 'info')
		}
	});
}

/////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
@endsection
