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
				<a class="nav-link active" href="{{ route('leaveEditing.index') }}">Leave</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('tcms.index') }}">TCMS</a>
			</li>
		</ul>

		<div class="card">
			<div class="card-header">Leaves Management</div>
			<div class="card-body">
				@include('generalAndAdministrative.hr.leave.settings.content')
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
// datatables
$.fn.dataTable.moment( 'ddd, D MMM YYYY' );
$.fn.dataTable.moment( 'ddd, D MMM YYYY h:mm a' );
$('#almcml1').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	// "order": [[5, "desc" ]],	// sorting the 4th column descending
	// responsive: true
	// "ordering": false
});

$('#almcml2').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	// "order": [[5, "desc" ]],	// sorting the 4th column descending
	// responsive: true
	// "ordering": false
});

/////////////////////////////////////////////////////////////////////////////////////////
// delete almcml for user
$(document).on('click', '.delete_almcml', function(e){
	
	var almcml_id = $(this).data('id');
	SwalDelete1(almcml_id);
	e.preventDefault();
});

function SwalDelete1(almcml_id){
	swal.fire({
		title: 'Are you sure?',
		text: "It will be deleted permanently!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					type: 'DELETE',
					url: '{{ url('staffAnnualMCLeave') }}' + '/' + almcml_id,
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: almcml_id,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal.fire('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_almcml_' + almcml_id).parent().parent().remove();
				})
				.fail(function(){
					swal.fire('Oops...', 'Something went wrong with ajax !', 'error');
				})
			});
		},
		allowOutsideClick: false			  
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal.fire('Cancelled', 'Your data is safe from delete', 'info')
		}
	});
}

/////////////////////////////////////////////////////////////////////////////////////////
// generate almcml
$(document).on('click', '#galmcml', function(e){
	
	var almcmly = $(this).data('id');
	SwalDelete(almcmly);
	e.preventDefault();
});

function SwalDelete(almcmly){
	swal.fire({
		title: 'Are you sure to generate AL, MC and ML for all active user in ' + almcmly + ' ?',
		text: "Please note that the new intake will have to manually add for the next year once this function is used.",
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, generate it!',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					type: 'POST',
					url: '{{ route('staffAnnualMCLeave.storeALMCML') }}',
					data: {
							'_token' : $('meta[name=csrf-token]').attr('content'),
							'almcmly': almcmly,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal.fire('Success generate all AL, MC and ML!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					// $('#delete_nrl_' + almcmly).parent().parent().remove();
				})
				.fail(function(){
					swal.fire('Oops...', 'Something went wrong with ajax !', 'error');
				})
			});
		},
		allowOutsideClick: false			  
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal.fire('Cancelled', 'Generate AL, MC and ML is cancelled.', 'info')
		}
	});
}

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

