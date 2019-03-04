@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Task List</h1></div>
	<div class="card-body table-responsive">
		@include('layouts.info')
		@include('layouts.errorform')

{!! Form::model($todoList, ['route' => ['todoList.update', $todoList->id], 'method' => 'PATCH', 'class' => 'form', 'autocomplete' => 'off', 'files' => true]) !!}
	@include('todolist._edit')
{!! Form::close() !!}

	</div>
	<div class="card-footer"></div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$(document).on('keyup', '#rem', function(e){
// $("#rem").keyup(function() {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
// datatables
$.fn.dataTable.moment( 'ddd, D MMMM YYYY' );	// Tue, 1 January 2019
// $.fn.dataTable.moment( 'dddd, D MMM YYYY h:mm a' );	// Tuesday, 1 Jan 2014 1:00 am
$('#todolist1').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[5, "asc" ]],	// sorting the 4th column descending
	// responsive: true
	// "ordering": false
});

/////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
@endsection

