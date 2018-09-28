<div class="card">
	<div class="card-header">Edit {{ $staffHR->name }} Position Setting</div>
	<div class="card-body">

		<div class="row">
			{{ Form::label( 'pos', 'Position : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10 offset-sm-2 row">
				<div class="form-group col-sm-1"><label for="">{{ Form::radio('main') }} Main</label></div>
				<div class="form-group col-sm-3">{{ Form::select('main', [1 => 2]) }}</div>
				<div class="form-group col-sm-3">{{ Form::select('main', [1 => 2]) }}</div>
				<div class="form-group col-sm-3">{{ Form::select('main', [1 => 2]) }}</div>
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>
</div>
