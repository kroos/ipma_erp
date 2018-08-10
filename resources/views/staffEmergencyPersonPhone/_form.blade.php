<div class="card">
	<div class="card-header">
		<h2 class="card-title">Emergency Contact Person Phone</h2>
	</div>
	<div class="card-body">

		<div class="form-group row {{ $errors->has('phone') ? 'has-error' : '' }}">
			{{ Form::label( 'npasa', 'Telefon : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('phone', @$value, ['class' => 'form-control', 'id' => 'npasa', 'placeholder' => 'Telefon', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>
</div>
