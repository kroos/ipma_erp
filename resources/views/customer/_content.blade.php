	<div class="card">
		<div class="card-header">
			Customer List
			<a href="{!! route('customer.create') !!}" class="btn btn-primary float-right">Add Customer</a>
		</div>
		<div class="card-body">
			<table class="table table-hover table-sm" style="font-size:12px" id="cust11">
				<thead>
					<tr>
						<th>Client</th>
						<th>PIC</th>
						<th>Address</th>
						<th>Phone</th>
						<th>Fax</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
@foreach(\App\Model\Customer::all() as $k)
					<tr>
						<td>{{ $k->customer }}</td>
						<td>{{ $k->pc }}</td>
						<td>
							{{ $k->address1 }}
							<br />{{ $k->address2 }}
							<br />{{ $k->address3 }}
							<br />{{ $k->address4 }}
						</td>
						<td>{{ $k->phone }}</td>
						<td>{{ $k->fax }}</td>
						<td>
							<div class="row">
								<a href="{!! route('customer.edit', $k->id) !!}" title="Update"><i class="far fa-edit"></i></a>
								<span class="text-danger delete_customer" data-id="{!! $k->id !!}" title="Delete"><i class="far fa-trash-alt"></i></span>
							</div>
						</td>
					</tr>
@endforeach
				</tbody>
			</table>
		</div>
	</div>