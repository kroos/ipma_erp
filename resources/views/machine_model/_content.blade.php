<div class="card">
	<div class="card-header">
		Machine Model List
		<a href="{!! route('machine_model.create') !!}" class="btn btn-primary float-right">Add Machine Model</a>
	</div>
	<div class="card-body">
		<table class="table table-sm table-hover" style="font-size: 12px" id="mmodel">
			<thead>
				<tr>
					<th>ID</th>
					<th>Model</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
@foreach(\App\Model\ICSMachineModel::all() as $k)
				<tr>
					<td>{{ $k->id }}</td>
					<td>{{ $k->model }}</td>
					<td>
						<div class="row">
							<a href="{!! route('machine_model.edit', $k->id) !!}" title="Update"><i class="far fa-edit"></i></a>
							<span class="text-danger delete_model" data-id="{!! $k->id !!}" title="Delete"><i class="far fa-trash-alt"></i></span>
						</div>
					</td>
				</tr>
@endforeach
			</tbody>
		</table>
	</div>
</div>