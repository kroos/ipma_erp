<div class="card">
	<div class="card-header">
		<h2 class="card-title">Add Working Hour</h2>
	</div>
	<div class="card-body">

		<div class="form-group row {{ ($errors->has('effective_date_start') || $errors->has('effective_date_end')) ? ' has-error' : '' }}">
			{{ Form::label( 'yea', 'Ramadhan Duration : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-5">
				{{ Form::text('effective_date_start', @$value, ['class' => 'form-control', 'id' => 'effective_date_start', 'placeholder' => 'Ramadhan Start', 'autocomplete' => 'off']) }}
			</div>
			<div class="col-sm-5">
				{{ Form::text('effective_date_end', @$value, ['class' => 'form-control', 'id' => 'effective_date_end', 'placeholder' => 'Ramadhan End', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>
	</div>
</div>
