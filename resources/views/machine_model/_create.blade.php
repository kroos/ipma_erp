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