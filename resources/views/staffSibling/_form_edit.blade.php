<div class="card">
	<div class="card-header">
		<h2 class="card-title">Edit Sibling</h2>
	</div>
	<div class="card-body">

		<div class="row col-sm-12 form-row">

			<div class="col-sm-3">
				<div class="form-group {{ $errors->has('spouse') ? 'has-error' : '' }}">
					{{ Form::text('sibling', @$value, ['class' => 'form-control', 'id' => 'npasa', 'placeholder' => 'Nama Saudara Kandung', 'autocomplete' => 'off']) }}
				</div>
			</div>

			<div class="col-sm-2">
				<div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
					{{ Form::text('phone', @$value, ['class' => 'form-control', 'id' => 'fon', 'placeholder' => 'Telefon', 'autocomplete' => 'off']) }}
				</div>
			</div>

			<div class="col-sm-2">
				<div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
					{{ Form::text('dob', @$value, ['class' => 'form-control', 'id' => 'dob', 'placeholder' => 'Tarikh Lahir', 'autocomplete' => 'off']) }}
				</div>
			</div>

			<div class="col-sm-2">
				<div class="form-group {{ $errors->has('profession') ? 'has-error' : '' }}">
					{{ Form::text('profession', @$value, ['class' => 'form-control', 'id' => 'profession', 'placeholder' => 'Pekerjaan', 'autocomplete' => 'off']) }}
				</div>
			</div>

		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>

</div>
