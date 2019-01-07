@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>General & Administrative Division</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<ul class="nav nav-tabs">
<?php
// foreach( App\Model\Division::find(1)->hasmanydepartment()->whereNotIn('id', [22, 23, 24])->get() as $key)
?>
@foreach( App\Model\Division::find(1)->hasmanydepartment()->get() as $key)
			<li class="nav-item">
				<a class="nav-link" href="{{ route("$key->route.index") }}">{{ $key->department }}</a>
			</li>
@endforeach
		</ul>
		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link active" href="{!! route('todoSchedule.index') !!}">To Do Task</a>
			</li>
		</ul>
		<div class="card">
			<div class="card-header">
				To Do Schedule
				<a class="btn btn-primary float-right" href="{!! route('todoSchedule.create') !!}">Create Task</a>
			</div>
			<div class="card-body">
@include('generalAndAdministrative.admin.todolist._index')
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
$.fn.dataTable.moment( 'dddd, D MMM YYYY h:mm a' );
$('#schedule1').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	// "order": [[5, "desc" ]],	// sorting the 4th column descending
	// responsive: true
	// "ordering": false
});

$('#schedule2').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[10, "desc" ]],	// sorting the 4th column descending
	// responsive: true
	// "ordering": false
});

$('#schedule3').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[10, "desc" ]],	// sorting the 4th column descending
	// responsive: true
	// "ordering": false
});

/////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ajax post approval
$(document).on('click', '.toggle', function(e){
	var tdsid = $(this).data('id');
	var tdsval = $(this).data('value');
	SwalToggle(tdsid, tdsval);
	e.preventDefault();
});

function SwalToggle(tdsid, tdsval){
	swal({
		title: 'Toggle Task Enable or Disable',
		text: 'Toggle this task?',
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Toggle',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: '{{ url('todoSchedule') }}' + '/' + tdsid + '/updatetoggle',
					type: 'PATCH',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: tdsid,
							active: tdsval,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Toggle Success!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_logistic_' + tdsval).parent().parent().remove();
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
			swal('Cancelled', 'Task Unchange', 'info')
		}
	});
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
@endsection

