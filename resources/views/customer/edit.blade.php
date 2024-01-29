@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Customer</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

{{ Form::model( $customer, ['route' => ['customer.update', $customer->id], 'method' => 'PATCH', 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) }}
	@include('customer._create')
{{ Form::close() }}
		
	</div>
</div>
@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$(document).on('keyup', 'input', function () {
//	uch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
// table
// $.fn.dataTable.moment( 'ddd, D MMM YYYY' );
$("#cust11").DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[0, "asc" ]],	// sorting the 2nd column ascending
	// responsive: true
});

// user disable
$(document).on('click', '.delete_customer', function(e){
	
	var productId = $(this).data('id');
	SwalDelete(productId);
	e.preventDefault();
});

function SwalDelete(productId){
	swal({
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
					url: '{{ url('customer') }}' + '/' + productId,
					data: {
							_token : $('meta[name=csrf-token]').attr('content'),
							id: productId,
					},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					//$('#disable_user_' + productId).parent().parent().remove();
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
			swal('Cancelled', 'Your data is safe from delete', 'info')
		}
	});
}

/////////////////////////////////////////////////////////////////////////////////////////
// bootstrap validator

$('#form').bootstrapValidator({
	feedbackIcons: {
		valid: '',
		invalid: '',
		validating: ''
	},
	fields: {
		customer: {
			validators: {
				notEmpty: {
					message: 'Customer name is required. '
				},
			}
		},
		pc: {
			validators: {
				notEmpty: {
					message: 'Please insert this field. '
				},
			}
		},
		address1: {
			validators: {
				notEmpty: {
					message: 'Please insert this field. '
				},
			}
		},
		address2: {
			validators: {
				notEmpty: {
					message: 'Please insert this field. '
				},
			}
		},
		phone: {
			validators: {
				notEmpty: {
					message: 'Please insert this field. '
				},
				digits: {
					message: 'Only numbers. '
				},
			}
		},
		fax: {
			validators: {
				digits: {
					message: 'Only numbers. '
				},
			}
		},
		email: {
			validators: {
				// notEmpty: {
				// 	message: 'Please insert this field. '
				// },
				emailAddress: {
					message: 'The value is not a valid email address. '
				},
			}
		},
	}
});
@endsection

