@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Customer Service Department</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<ul class="nav nav-tabs">
@foreach( App\Model\Division::find(3)->hasmanydepartment()->whereNotIn('id', [22, 23, 24])->get() as $key)
			<li class="nav-item">
				<a class="nav-link {{ ($key->id == 10)? 'active' : 'disabled' }}" href="{{ route("$key->route.index") }}">{{ $key->department }}</a>
			</li>
@endforeach
		</ul>

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('serviceReport.index') }}">Intelligence Customer Service</a>
			</li>
<!-- 			<li class="nav-item">
				<a class="nav-link" href="">Cost Planning System</a>
			</li> -->
		</ul>
		<div class="card">
			<div class="card-header">Intelligence Customer Service<a href="{{ route('serviceReport.create') }}" class="btn btn-primary float-right">Add Service Report</a></div>
			<div class="card-body table-responsive"">
@include('marketingAndBusinessDevelopment.customerservice.ics._content')
			</div>
		</div>


	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// date for ajax
$('#date').datetimepicker({
	format:'YYYY-MM-DD',
	useCurrent: false,
})
// .on('dp.change dp.show dp.update', function() {
	// $('#form').bootstrapValidator('revalidateField', 'date');
// })
;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ajax post courtesy call
$(document).on('click', '.courtesycall', function(e){
	var srCCall = $(this).data('id');
	SwalCCallSR(srCCall);
	e.preventDefault();
});

function SwalCCallSR(srCCall){
	swal({
		title: 'Service Report Feedback Courtesy Call',
		text: 'Courtesy Call Feedback',
		type: 'question',
		html:
			'<div class="form-group row">' +
				'{!! Form::label('date', 'Date :', ['class' => 'col-sm-4 col-form-label']) !!}' +
				'<div class="col-sm-8">' +
					'{!! Form::text('date', @$value, ['class' => 'form-control form-control-sm', 'id' => 'date', 'placeholder' => 'YYYY-MM-DD', 'required' => 'required']) !!}' +
				'</div>' +
			'</div>' +
			'<div class="form-group row">' +
				'{!! Form::label('date', 'Customer PIC :', ['class' => 'col-sm-4 col-form-label']) !!}' +
				'<div class="col-sm-8">' +
					'{!! Form::text('pic', @$value, ['class' => 'form-control form-control-sm', 'id' => 'pic', 'placeholder' => 'Person In Charge', 'required' => 'required']) !!}' +
				'</div>' +
			'</div>' +
			'<div class="form-group row">' +
				'{!! Form::label('rem', 'Remarks :', ['class' => 'col-sm-4 col-form-label']) !!}' +
				'<div class="col-sm-8">' +
					'{!! Form::textarea('remarks', @$value, ['class' => 'form-control form-control-sm', 'id' => 'rem', 'placeholder' => 'Remarks', 'required' => 'required']) !!}' +
				'</div>' +
			'</div>',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Save',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				var date = document.getElementById('date').value;
				var pic = document.getElementById('pic').value;
				var remarks = document.getElementById('rem').value;
				$.ajax({
					url: '{{ route('srCCall.store') }}',
					type: 'POST',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							service_report_id: srCCall,
							date: date,
							pic: pic,
							remarks: remarks,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Courtesy Call Saved!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_logistic_' + srCCall).parent().parent().remove();
				})
				.fail(function(responser){
					var resp = responser.responseJSON;
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
			swal('Cancelled', 'Unsaved Service Report Courtesy Call', 'info')
		}
	});
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$("#username").keyup(function() {
	uch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
// table
$.fn.dataTable.moment( 'ddd, D MMM YYYY' );
$('#servicereport1').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[1, "asc" ]],	// sorting the 2nd column ascending
	// responsive: true
});

$('#servicereport2').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[1, "asc" ]],	// sorting the 2nd column ascending
	// responsive: true
});

$('#servicereport3').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[2, "asc" ]],	// sorting the 2nd column ascending
	// responsive: true
});

$('#servicereport4').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[1, "asc" ]],	// sorting the 2nd column ascending
	// responsive: true
});

$('#servicereport5').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[1, "asc" ]],	// sorting the 2nd column ascending
	// responsive: true
});

$('#servicereport6').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[1, "asc" ]],	// sorting the 2nd column ascending
	// responsive: true
});

/////////////////////////////////////////////////////////////////////////////////////////
// update unapproved
$('#selectAll').on('click',function(){
	if(this.checked){
		$('.checkbox1').each(function(){
			this.checked = true;
		});
	}else{
		$('.checkbox1').each(function(){
			this.checked = false;
		});
	}
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ajax post approval
$(document).on('click', '.approval', function(e){
	var srDisc = $(this).data('id');
	SwalApproveSR(srDisc);
	e.preventDefault();
});

function SwalApproveSR(srDisc){
	swal({
		title: 'Service Report Approval',
		text: 'Approve This Service Report?',
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Approve',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: '{{ url('serviceReport') }}' + '/' + srDisc + '/updateApproveSR',
					type: 'PATCH',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: srDisc,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Approved!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_logistic_' + srDisc).parent().parent().remove();
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
			swal('Cancelled', 'Service Report Not Approve', 'info')
		}
	});
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ajax post inactive
$(document).on('click', '.inactivate', function(e){
	var sRinact = $(this).data('id');
	SwalInactiveSR(sRinact);
	e.preventDefault();
});

function SwalInactiveSR(sRinact){
	swal({
		title: 'Deactivate Service Report',
		text: 'Deactivate This Service Report?',
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Deactivate',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: '{{ url('serviceReport') }}' + '/' + sRinact + '/updateDeactivate',
					type: 'PATCH',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: sRinact,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Approved!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_logistic_' + sRinact).parent().parent().remove();
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
			swal('Cancelled', 'Service Report Active', 'info')
		}
	});
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ajax post send to account
$(document).on('click', '.send', function(e){
	var sRsend = $(this).data('id');
	SwalSendSR(sRsend);
	e.preventDefault();
});

function SwalSendSR(sRsend){
	swal({
		title: 'Service Report Transfer To Account',
		text: 'Send This Service Report To Account?',
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
					url: '{{ url('serviceReport') }}' + '/' + sRsend + '/sendSR',
					type: 'PATCH',
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: sRsend,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Approved!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#delete_logistic_' + sRsend).parent().parent().remove();
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
			swal('Cancelled', 'Service Report Not Send', 'info')
		}
	});
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
@endsection

