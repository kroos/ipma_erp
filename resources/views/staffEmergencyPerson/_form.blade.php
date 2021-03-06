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

		<div class="form-group row {{ $errors->has('emer.1.phone') ? 'has-error' : '' }}">
			{{ Form::label( 'phone_emergency_person', 'Telefon : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">

				<div class="container-fluid emerg_person_wrap">
					<div class="rowemerg_person">
						<div class="row col-sm-12">
							<div class="col-sm-1">
								<button class="btn btn-danger remove_emerg_person" type="button">
									<i class="fas fa-trash" aria-hidden="true"></i>
								</button>
							</div>

							<div class="col-sm-11">
								<div class="form-group {{ $errors->has('staff.*.spouse') ? 'has-error' : '' }}">
									{{ Form::text('emerg[1][phone]', @$value, ['class' => 'form-control', 'id' => 'npasa', 'placeholder' => 'Telefon', 'autocomplete' => 'off']) }}
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row col-lg-12">
					<p>
						<button class="btn btn-primary add_emerg_person" type="button">
							<i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add More Emergency Contact Person
						</button>
					</p>
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
