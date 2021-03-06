<div class="card">
	<div class="card-header">
		Exclusion
		<a href="{!! route('quotExcl.create') !!}" class="btn btn-primary float-right">Add Exclusion</a>
	</div>
	<div class="card-body">
		<table class="table table-sm table-hover" style="font-size: 12px" id="mmodel">
			<thead>
				<tr>
					<th>ID</th>
					<th>Exclusion</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
@foreach(\App\Model\QuotExclusion::all() as $k)
				<tr>
					<td>{{ $k->id }}</td>
					<td>{{ $k->exclusion }}</td>
					<td class="row">
						<a href="{!! route('quotExcl.edit', $k->id) !!}" title="Update"><i class="far fa-edit"></i></a>
						<!-- <span class="text-danger delete_item" data-id="{!! $k->id !!}" title="Delete"><i class="far fa-trash-alt"></i></span> -->
					</td>
				</tr>
@endforeach
			</tbody>
		</table>
	</div>
</div>