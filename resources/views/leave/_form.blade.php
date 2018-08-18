<div class="col-6">
	<div class="card">
		<div class="card-header">
			<h2 class="card-title">Children</h2>
		</div>
		<div class="card-body">

						<div class="form-group row {{ $errors->has('children') ? 'has-error' : '' }}">
							{{ Form::label( 'npasa', 'Nama Anak : ', ['class' => 'col-sm-2 col-form-label'] ) }}
							<div class="col-sm-10">
								{{ Form::text('children', @$value, ['class' => 'form-control', 'id' => 'npasa', 'placeholder' => 'Nama Anak', 'autocomplete' => 'off']) }}
							</div>
						</div>

						<div class="form-group row {{ $errors->has('dob') ? 'has-error' : '' }}">
							{{ Form::label( 'dob_1', 'Tarikh Lahir : ', ['class' => 'col-sm-2 col-form-label'] ) }}
							<div class="col-sm-10">
								{{ Form::text('dob', @$value, ['class' => 'form-control', 'id' => 'dob_1', 'placeholder' => 'Tarikh Lahir', 'autocomplete' => 'off']) }}
							</div>
						</div>
	<?php
	$gender = App\Model\Gender::pluck('gender', 'id')->sortKeys()->toArray();
	?>
						<div class="form-group row {{ $errors->has('gender_id') ? 'has-error' : '' }}">
							{{ Form::label( 'gen', 'Jantina : ', ['class' => 'col-sm-2 col-form-label'] ) }}
							<div class="col-sm-10">
								{{ Form::select('gender_id', $gender, @$value, ['class' => 'form-control', 'id' => 'gen', 'placeholder' => 'Jantina', 'autocomplete' => 'off']) }}
							</div>
						</div>
	<?php
	$eduLevel = App\Model\EducationLevel::pluck('education_level', 'id')->sortKeys()->toArray();
	?>
						<div class="form-group row {{ $errors->has('education_level_id') ? 'has-error' : '' }}">
							{{ Form::label( 'edulevel', 'Tahap Pengajian : ', ['class' => 'col-sm-2 col-form-label'] ) }}
							<div class="col-sm-10">
								{{ Form::select('education_level_id', $eduLevel, @$value, ['class' => 'form-control', 'id' => 'edulevel', 'placeholder' => 'Tahap Pelajaran', 'autocomplete' => 'off']) }}
							</div>
						</div>
	<?php
	$healthStat = App\Model\HealthStatus::pluck('health_status', 'id')->sortKeys()->toArray();
	?>
						<div class="form-group row {{ $errors->has('health_status_id') ? 'has-error' : '' }}">
							{{ Form::label( 'healthStat', 'Tahap Kesihatan : ', ['class' => 'col-sm-2 col-form-label'] ) }}
							<div class="col-sm-10">
								{{ Form::select('health_status_id', $healthStat, @$value, ['class' => 'form-control', 'id' => 'healthStat', 'placeholder' => 'Tahap Kesihatan', 'autocomplete' => 'off']) }}
							</div>
						</div>

						<div class="form-group row {{ $errors->has('tax_exemption') ? 'has-error' : '' }}" >
							{{ Form::label( 'te', 'Pengecualian Cukai Keatas Anak : ', ['class' => 'col-sm-2 col-form-label'] ) }}
							<div class="col-sm-10">
								<div class="pretty p-default p-curve p-has-hover">
									<input type='hidden' value='0' name='tax_exemption'>
									<input type="checkbox" name="tax_exemption" value="1" class="form-check" id="te" {{ (isset($staffChild->tax_exemption))?($staffChild->tax_exemption == 1)?'checked':'':'' }}>
									<div class="state p-success-o">
										<label>Dikecualikan Cukai</label>
									</div>
									<div class="state p-is-hover">
										<label>Klik untuk pengecualian cukai keatas anak.</label>
									</div>
								</div>
							</div>
						</div>
	<?php
	$taxExemp = \App\Model\TaxExemptionPercentage::pluck('tax_exemption_percentage', 'id')->sortKeys()->toArray();
	?>
						<div class="form-group row {{ $errors->has('staff.*.tax_exemption_percentage_id') ? 'has-error' : '' }}" id="hidden">
							{{ Form::label( 'taxExempPercent', 'Peratus Pengecualian Cukai : ', ['class' => 'col-sm-2 col-form-label'] ) }}
							<div class="col-sm-10">
								{{ Form::select('tax_exemption_percentage_id', $taxExemp, @$value, ['class' => 'form-control', 'id' => 'taxExempPercent', 'placeholder' => 'Peratus Pengecualian Cukai', 'autocomplete' => 'off']) }}
							</div>
						</div>


			<div class="form-group row">
				<div class="col-sm-10 offset-sm-2">
					{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
				</div>
			</div>

		</div>

	</div>
</div>