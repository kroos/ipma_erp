@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Costing Department</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<ul class="nav nav-tabs">
@foreach( App\Model\Division::find(3)->hasmanydepartment()->whereNotIn('id', [22, 23, 24])->get() as $key)
			<li class="nav-item">
				<a class="nav-link {{ ($key->id == 7)? 'active' : 'disabled' }}" href="{{ route("$key->route.index") }}">{{ $key->department }}</a>
			</li>
@endforeach
		</ul>

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('quot.index') }}">Quotation</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('ics.costing') }}">Intelligence Customer Service</a>
			</li>
		</ul>

		<div class="card">
			<div class="card-header">
				Quotation List
				<a href="{{ route('quot.create') }}" class="btn btn-primary float-right">Add Quotation</a>
			</div>
			<div class="card-body">

				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('customer.index') }}">Customer</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('machine_model.index') }}">Model</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quotdd.index') }}">UOM Delivery Date Period</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quotItem.index') }}">Product / Item</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quotItemAttrib.index') }}">Product / Item Attribute</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quotUOM.index') }}">Unit Of Measurement</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quotRem.index') }}">Remarks</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quotExcl.index') }}">Exclusion</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quotDeal.index') }}">Dealer</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quotWarr.index') }}">Warranty</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('quotBank.index') }}">Bank</a>
					</li>
				</ul>

				@include('marketingAndBusinessDevelopment.costing.quotation._content')
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
$.fn.dataTable.moment( 'ddd, D MMM YYYY' );
$('#quot1').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"order": [[2, "desc" ]],	// sorting the 2nd column ascending
	// responsive: true
});

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

