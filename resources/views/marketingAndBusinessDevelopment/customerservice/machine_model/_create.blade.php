<div class="card">
	<div class="card-header">Add Machine Model</div>
	<div class="card-body">

		<div class="form-group row {{ $errors->has('model')?'has-error':'' }}">
			{{ Form::label( 'model', 'Machine Model : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{!! Form::text('model', @$value, ['class' => 'form-control', 'id' => 'cust', 'placeholder' => 'Machine Model', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>
</div>
<p>&nbsp;</p>
<div class="card">
	<div class="card-header">List of Machine Model</div>
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