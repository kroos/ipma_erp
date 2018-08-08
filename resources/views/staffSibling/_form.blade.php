<div class="card">
	<div class="card-header">
		<h2 class="card-title">Add Sibling</h2>
	</div>
	<div class="card-body">

		<div class="container-fluid sibling_wrap">
			<div class="rowsibling">
				<div class="row col-sm-12">

					<div class="col-sm-1">
						<button class="btn btn-danger remove_sibling" type="button">
							<i class="fas fa-trash" aria-hidden="true"></i>
						</button>
					</div>

					<div class="col-sm-4">
						<div class="form-group {{ $errors->has('staff.*.sibling') ? 'has-error' : '' }}">
							{{ Form::text('staff[1][sibling]', @$value, ['class' => 'form-control', 'id' => 'npasa', 'placeholder' => 'Nama Saudara', 'autocomplete' => 'off']) }}
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

					<div class="col-sm-3">
						<div class="form-group {{ $errors->has('staff.*.profession') ? 'has-error' : '' }}">
							{{ Form::text('staff[1][profession]', @$value, ['class' => 'form-control', 'id' => 'profession', 'placeholder' => 'Pekerjaan', 'autocomplete' => 'off']) }}
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="row col-lg-12">
			<p>
				<button class="btn btn-primary add_sibling" type="button">
					<i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add More Sibling
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
