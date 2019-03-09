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
				<a class="nav-link" href="{{ route('serviceReport.index') }}">Intelligence Customer Service</a>
			</li>
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('csOrder.index') }}">Customer Order Item</a>
			</li>
		</ul>
		<div class="card">
			<div class="card-header">Add Customer Order</div>
			<div class="card-body">
{!! Form::open(['route' => ['csOrder.store'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) !!}
@include('marketingAndBusinessDevelopment.customerservice.order_item._create')
{{ Form::close() }}
			</div>
		</div>


	</div>
</div>
@endsection
@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$(document).on('keyup', '#req, #rem, #oid_1, #oi_1', function () {
	uch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
// table
// $.fn.dataTable.moment( 'ddd, D MMM YYYY' );
// $("#mmodel").DataTable({
// 	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
// 	"order": [[1, "asc" ]],	// sorting the 2nd column ascending
// 	// responsive: true
// });

/////////////////////////////////////////////////////////////////////////////////////////
$('#dat').datetimepicker({
	format:'YYYY-MM-DD',
	useCurrent: true,
})
.on('dp.change dp.show dp.update', function() {
	$('#form').bootstrapValidator('revalidateField', 'date');
});

/////////////////////////////////////////////////////////////////////////////////////////
$('#cust, #iby, #pi, #ois_1').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
// add position : add and remove row
<?php
$csois = \App\Model\CSOrderItemStatus::all();
?>

var max_fields	= 100; //maximum input boxes allowed
var add_buttons	= $(".add_orderitem");
var wrappers	= $(".orderitem_wrap");

var xs = 1;
$(add_buttons).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(xs < max_fields){
		xs++;
		wrappers.append(

			'<div class="roworderitem">' +
				'<div class="col-sm-12 form-row ">' +
					'<div class="col-sm-1 text-danger">' +
							'<i class="fas fa-trash remove_item" aria-hidden="true" id="delete_item_' + xs + '"></i>' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('csoi.*.order_item') ? 'has-error' : '' }}">' +
						'<input type="text" name="csoi[' + xs + '][order_item]" class="form-control form-control-sm" id="oi_' + xs + '" autocomplete="off" placeholder="Item/Parts">' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('csoi.*.order_item_status_id') ? 'has-error' : '' }}">' +
						'<select name="csoi[' + xs + '][order_item_status_id]" id="ois_' + xs + '" class="form-control form-control-sm" autocomplete="off" placeholder="Please choose">' +
							'<option value="">Please choose</option>' +
@foreach( \App\Model\CSOrderItemStatus::all() as $mod )
							'<option value="{!! $mod->id !!}">{!! $mod->order_item_status !!}</option>' +
@endforeach
						'</select>' +
					'</div>' +
					'<div class="form-group col {{ $errors->has('csoi.*.description') ? 'has-error' : '' }}">' +
						'<textarea name="csoi[' + xs + '][description]" id="oid_' + xs + '" class="form-control form-control-sm" placeholder="Remarks for Item"></textarea>' +
					'</div>' +
				'</div>' +
			'</div>'

		); //add input box

		$('#ois_' + xs).select2({
			placeholder: 'Please choose',
			allowClear: true,
			closeOnSelect: true,
			width: '100%',
		});
		
		$(document).on('keyup', '#oi_' + xs +', #oid_' + xs, function () {
			uch(this);
		});

		//bootstrap validate
		$('#form').bootstrapValidator('addField',	$('.roworderitem')	.find('[name="csoi[' + xs + '][order_item]"]'));
		$('#form').bootstrapValidator('addField',	$('.roworderitem')	.find('[name="csoi[' + xs + '][order_item_status_id]"]'));
		$('#form').bootstrapValidator('addField',	$('.roworderitem')	.find('[name="csoi[' + xs + '][description]"]'));
	}
});

$(wrappers).on("click",".remove_item", function(e){
	//user click on remove text
	e.preventDefault();
	//var $row = $(this).parent('.roworderitem');
	var $row = $(this).parent().parent().parent();
	var $option1 = $row.find('[name="csoi[][order_item]"]');
	var $option2 = $row.find('[name="csoi[][order_item_status_id]"]');
	var $option3 = $row.find('[name="csoi[][description]"]');
	$row.remove();

	$('#form').bootstrapValidator('removeField', $option1);
	$('#form').bootstrapValidator('removeField', $option2);
	$('#form').bootstrapValidator('removeField', $option3);
	console.log(xs);
	xs--;
})

/////////////////////////////////////////////////////////////////////////////////////////
// user disable
$(document).on('click', '.delete_model', function(e){
	
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
					url: '{{ url('machine_model') }}' + '/' + productId,
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
		date: {
			validators: {
				notEmpty: {
					message: 'Machne model name is required. '
				},

			}
		},
		customer_id: {
			validators: {
				notEmpty: {
					message: 'Please choose. '
				}
			}
		},
		requester: {
			validators: {
				notEmpty: {
					message: 'Please insert Requester. '
				}
			}
		},
		informed_by: {
			validators: {
				notEmpty: {
					message: 'Please choose. '
				}
			}
		},
		pic: {
			validators: {
				notEmpty: {
					message: 'Please choose. '
				}
			}
		},
		description: {
			validators: {
				// notEmpty: {
				// 	message: 'Please choose. '
				// }
			}
		},
@for($i = 1; $i <= 100; $i++)
		'csoi[{!! $i !!}][order_item]': {
			validators: {
				notEmpty: {
					message: 'Please insert Item/Part. '
				}
			}
		},
		'csoi[{!! $i !!}][order_item_status_id]': {
			validators: {
				notEmpty: {
					message: 'Please choose. '
				}
			}
		},
		'csoi[{!! $i !!}][description]': {
			validators: {
				// notEmpty: {
				// 	message: 'Please Remarks. '
				// }
			}
		},
@endfor
	}
});
@endsection

