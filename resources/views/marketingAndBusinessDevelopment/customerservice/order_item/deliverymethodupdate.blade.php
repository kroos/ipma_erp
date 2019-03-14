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
			<div class="card-header">Delivery Method For Order Item</div>
			<div class="card-body">
{!! Form::open(['route' => ['csOrder.deliverymethodstore'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) !!}
@include('marketingAndBusinessDevelopment.customerservice.order_item._deliverymethodupdate')
{{ Form::close() }}
			</div>
		</div>


	</div>
</div>
@endsection
@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
// $(document).on('keyup', '#req, #rem, #oid_1, #oi_1, #oiai_1, #custpono, #refno', function () {
// 	uch(this);
// });

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
	$('#form').bootstrapValidator('revalidateField', 'delivery_date');
});

/////////////////////////////////////////////////////////////////////////////////////////
$('#dm').select2({
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
// bootstrap validator

$('#form').bootstrapValidator({
	feedbackIcons: {
		valid: 'fas fa-check',
		invalid: 'fas fa-times',
		validating: 'fas fa-spinner'
	},
	fields: {
		delivery_date: {
			validators: {
				notEmpty: {
					message: 'Delivery Date is required. '
				},

			}
		},
		delivery_id: {
			validators: {
				notEmpty: {
					message: 'Please choose. '
				}
			}
		},
		delivery_remarks: {
			validators: {
				// notEmpty: {
				// 	message: 'Please insert Requester. '
				// }
			}
		},
	}
});
@endsection

