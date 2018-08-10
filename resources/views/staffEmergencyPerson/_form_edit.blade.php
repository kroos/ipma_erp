<div class="card">
	<div class="card-header">
		<h2 class="card-title">Emergency Contact Person</h2>
	</div>
	<div class="card-body">

		<div class="form-group row {{ $errors->has('contact_person') ? 'has-error' : '' }}">
			{{ Form::label( 'npasa', 'Nama : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('contact_person', @$value, ['class' => 'form-control', 'id' => 'npasa', 'placeholder' => 'Nama', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('relationship') ? 'has-error' : '' }}">
			{{ Form::label( 'dob_1', 'Hubungan : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('relationship', @$value, ['class' => 'form-control', 'id' => 'dob_1', 'placeholder' => 'Hubungan', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('address') ? 'has-error' : '' }}">
			{{ Form::label( 'dob', 'Alamat : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::textarea('address', @$value, ['class' => 'form-control', 'id' => 'dob', 'placeholder' => 'Alamat', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>
</div>
