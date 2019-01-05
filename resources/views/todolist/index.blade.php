@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Task List</h1></div>
	<div class="card-body table-responsive">
		@include('layouts.info')
		@include('layouts.errorform')

@include('todolist._index')

	</div>
	<div class="card-footer"></div>
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
$.fn.dataTable.moment( 'ddd, D MMMM YYYY' );	// Tue, 1 January 2019
// $.fn.dataTable.moment( 'dddd, D MMM YYYY h:mm a' );	// Tuesday, 1 Jan 2014 1:00 am
$('#todolist1').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[5, "asc" ]],	// sorting the 4th column descending
	// responsive: true
	// "ordering": false
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ajax post courtesy call
$(document).on('click', '.update', function(e){
	var srCCall = $(this).data('id');
	SwalCCallSR(srCCall);
	// e.preventDefault();
});

function SwalCCallSR(srCCall){
	swal({
		title: 'Update Task List',
		text: 'Update TSchedule Task',
		type: 'question',
		html:
			'<div class="form-group row">' +
				'{!! Form::label('rem', 'Remarks :', ['class' => 'col-sm-4 col-form-label']) !!}' +
				'<div class="col-sm-8">' +
					'{!! Form::textarea('description', @$value, ['class' => 'form-control form-control-sm', 'id' => 'rem', 'placeholder' => 'Remarks', 'required' => 'required']) !!}' +
				'</div>' +
			'</div>' +
			'<div class="form-group row">' +
				'{!! Form::label('rem', 'Complete Task :', ['class' => 'col-sm-4 col-form-label']) !!}' +
				'<div class="col-sm-8">' +
					'<div class="form-check form-check-inline">' +
						'<input class="form-check-input acc" type="radio" name="completed" value="1" id="inlineRadio1">' +
						'<label class="form-check-label" for="inlineRadio1">Yes</label>' +
					'</div>' +
					'<div class="form-check form-check-inline">' +
						'<input class="form-check-input acc" type="radio" name="completed" value="0" id="inlineRadio2">' +
						'<label class="form-check-label" for="inlineRadio2">No</label>' +
					'</div>'
				'</div>' +
			'</div>',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Update',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: '{{ url('todoList') }}' + '/' + srCCall + '/updatetask',
					type: 'PATCH',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							description: $('#rem').val(),
							completed: $('input[name=completed]').val()
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Task Updated!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_logistic_' + srCCall).parent().parent().remove();
				})
				.fail(function(response){
					var resp = response.responseJSON;
					// console.log(resp.errors);
					var x = "";
 					for(i in resp.errors) {
						x += '<p class="text-danger">' + resp.errors[i] + '</p>';
					};
					swal({
						title: resp.message,
						html: x,
						type: 'error',
					});
				})
			});
		},
		allowOutsideClick: false			  
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal('Cancelled', 'Not Updating Task List', 'info')
		}
	});
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
@endsection

