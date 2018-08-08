<div class="card">
	<div class="card-header">
		<h2 class="card-title">Add Spouse</h2>
	</div>
	<div class="card-body">

		<div class="container-fluid spouse_wrap">
			<div class="rowspouse">
				<div class="row col-sm-12">

					<div class="col-sm-1">
						<button class="btn btn-danger remove_spouse" type="button">
							<i class="fas fa-trash" aria-hidden="true"></i>
						</button>
					</div>

					<div class="col-sm-3">
						<div class="form-group {{ $errors->has('staff.*.spouse') ? 'has-error' : '' }}">
							{{ Form::text('staff[1][spouse]', @$value, ['class' => 'form-control', 'id' => 'npasa', 'placeholder' => 'Nama Pasangan', 'autocomplete' => 'off']) }}
						</div>
					</div>

					<div class="col-sm-2">
						<div class="form-group {{ $errors->has('staff.*.id_card_passport') ? 'has-error' : '' }}">
							{{ Form::text('staff[1][id_card_passport]', @$value, ['class' => 'form-control', 'id' => 'iccard', 'placeholder' => 'ID Kad', 'autocomplete' => 'off']) }}
						</div>

					</div>

					<div class="col-sm-2">
						<div class="form-group {{ $errors->has('staff.*.phone') ? 'has-error' : '' }}">
							{{ Form::text('staff[1][phone]', @$value, ['class' => 'form-control', 'id' => 'fon', 'placeholder' => 'Telefon', 'autocomplete' => 'off']) }}
						</div>
					</div>

					<div class="col-sm-2">
						<div class="form-group {{ $errors->has('staff.*.dob') ? 'has-error' : '' }}">
							{{ Form::text('staff[1][dob]', @$value, ['class' => 'form-control', 'id' => 'dob_1', 'placeholder' => 'Tarikh Lahir', 'autocomplete' => 'off']) }}
						</div>
					</div>

					<div class="col-sm-2">
						<div class="form-group {{ $errors->has('staff.*.profession') ? 'has-error' : '' }}">
							{{ Form::text('staff[1][profession]', @$value, ['class' => 'form-control', 'id' => 'profession', 'placeholder' => 'Pekerjaan', 'autocomplete' => 'off']) }}
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="row col-lg-12">
			<p>
				<button class="btn btn-primary add_spouse" type="button">
					<i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add More Spouse
				</button>
			</p>
		</div>
		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>

</div>
