@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Account Department</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<ul class="nav nav-tabs">
@foreach( App\Model\Division::find(1)->hasmanydepartment()->whereNotIn('id', [22, 23, 24])->get() as $key)
			<li class="nav-item">
				<a class="nav-link {{ ($key->id == 1)? 'active' : 'disabled' }}" href="{{ route("$key->route.index") }}">{{ $key->department }}</a>
			</li>
@endforeach
		</ul>

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('ics.account') }}">Intelligence Customer Service</a>
			</li>
		</ul>
		<div class="card">
			<div class="card-header">Intelligence Customer Service</div>
			<div class="card-body">
				<div class="card">
					<div class="card-header">Service Report List</div>
					<div class="card-body table-responsive">
@include('generalAndAdministrative.account.ics._account')
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
$("#username").keyup(function() {
	uch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
// table
$.fn.dataTable.moment( 'ddd, D MMM YYYY' );
$('#servicereport5').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[7, "asc" ]],	// sorting the 2nd column ascending
	// responsive: true
});

$('#servicereport6').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[7, "asc" ]],	// sorting the 2nd column ascending
	// responsive: true
});

/////////////////////////////////////////////////////////////////////////////////////////
// update unapproved
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ajax post checked floatth
$(document).on('click', '.check', function(e){
	var sRcheck = $(this).data('id');
	SwalCheckSR(sRcheck);
	e.preventDefault();
});

function SwalCheckSR(sRcheck){
	swal.fire({
		title: 'Checking & Review Service Report',
		text: 'Checking Service Report',
		type: 'question',
		showCancelButton: true,
		cancelButtonText: 'No',
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: '{{ url('serviceReport') }}' + '/' + sRcheck + '/checkSR',
					type: 'PATCH',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: sRcheck,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal.fire('Approved!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_logistic_' + sRcheck).parent().parent().remove();
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
			swal.fire('Cancelled', 'Service Report Not Send', 'info')
		}
	});
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
@endsection

