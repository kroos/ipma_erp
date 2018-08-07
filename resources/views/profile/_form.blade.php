		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-12">

				</div>
			</div>
			<div class="card">

				<div class="card-header">
					<h2 class="card-title">{{ $staff->name }}</h2>
				</div>
				<div class="card-body">

					<div class="form-group row {{ $errors->has('image') ? ' has-error' : '' }}">
						{{ Form::label( 'image', 'Image : ', ['class' => 'col-sm-2 col-form-label'] ) }}
						<div class="col-auto">
							{{ Form::file( 'image', ['class' => 'form-control form-control-file', 'id' => 'image', 'placeholder' => 'Your Image']) }}
						</div>
					</div>


					<div class="row justify-content-center">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h2 class="card-title">Butiran</h2>
								</div>
								<div class="card-body">
<?php
$status = App\Model\Status::pluck('status', 'id')->sortKeys()->toArray();
?>
@if(Auth::user()->id != 0)
@else
									this should be only authorized personnel
									{{ Auth::user()->id }}
									<div class="form-group row {{ $errors->has('status_id') ? ' has-error' : '' }}">
										{{ Form::label( 'stat', 'Status : ', ['class' => 'col-sm-2 col-form-label'] ) }}
										<div class="col-sm-10">
											{{ Form::select( 'status_id', $status, @$value, ['class' => 'form-control', 'id' => 'stat', 'placeholder' => 'Please Select', 'autocomplete' => 'off'] ) }}
										</div>
									</div>
@endif
									<div class="form-group row {{ $errors->has('id_card_passport') ? ' has-error' : '' }}">
										{{ Form::label('iccard', 'Kad Pengenalan : ', ['class' => 'col-sm-2 col-form-label']) }}
										<div class="col-sm-10">
											{{ Form::text('id_card_passport', @$value, ['class' => 'form-control', 'id' => 'iccard', 'placeholder' => '801231101234', 'autocomplete' => 'off']) }}
										</div>
									</div>
<?php
$religion = App\Model\Religion::pluck('religion', 'id')->sortKeys()->toArray();
?>
									<div class="form-group row {{ $errors->has('religion_id') ? ' has-error' : '' }}">
										{{ Form::label('religion', 'Agama : ', ['class' => 'col-sm-2 col-form-label']) }}
										<div class="col-sm-10">
											{{ Form::select('religion_id', $religion, @$value, ['class' => 'form-control', 'id' => 'religion', 'placeholder' => 'Please Select', 'autocomplete' => 'off']) }}
										</div>
									</div>
<?php
$gender = App\Model\Gender::pluck('gender', 'id')->sortKeys()->toArray();
?>
									<div class="form-group row {{ $errors->has('gender_id') ? ' has-error' : '' }}">
										{{ Form::label('genderr', 'Jantina : ', ['class' => 'col-sm-2 col-form-label']) }}
										<div class="col-sm-10">
											{{ Form::select('gender_id', $gender, @$value, ['class' => 'form-control', 'id' => 'genderr', 'placeholder' => 'Please Select', 'autocomplete' => 'off']) }}
										</div>
									</div>

<?php
$race = App\Model\Race::pluck('race', 'id')->sortKeys()->toArray();
?>
									<div class="form-group row {{ $errors->has('race_id') ? ' has-error' : '' }}">
										{{ Form::label('racer', 'Bangsa : ', ['class' => 'col-sm-2 col-form-label']) }}
										<div class="col-sm-10">
											{{ Form::select('race_id', $race, @$value, ['class' => 'form-control', 'id' => 'racer', 'placeholder' => 'Please Select', 'autocomplete' => 'off']) }}
										</div>
									</div>

									<div class="form-group row {{ $errors->has('address') ? ' has-error' : '' }}">
										{{ Form::label('add', 'Alamat : ', ['class' => 'col-sm-2 col-form-label']) }}
										<div class="col-sm-10">
											{{ Form::textarea('address', @$value, ['class' => 'form-control', 'id' => 'add', 'placeholder' => 'Alamat', 'autocomplete' => 'off']) }}
										</div>
									</div>

									<div class="form-group row {{ $errors->has('place_of_birth') ? ' has-error' : '' }}">
										{{ Form::label('pob', 'Tempat Lahir : ', ['class' => 'col-sm-2 col-form-label']) }}
										<div class="col-sm-10">
											{{ Form::text('place_of_birth', @$value, ['class' => 'form-control', 'id' => 'pob', 'placeholder' => 'Tempat Lahir', 'autocomplete' => 'off']) }}
										</div>
									</div>
<?php
$country = App\Model\Country::pluck('country', 'id')->sortKeys()->toArray();
?>
									<div class="form-group row {{ $errors->has('country_id') ? ' has-error' : '' }}">
										{{ Form::label('count', 'Warganegara : ', ['class' => 'col-sm-2 col-form-label']) }}
										<div class="col-sm-10">
											{{ Form::select('country_id', $country, @$value, ['class' => 'form-control', 'id' => 'count', 'placeholder' => 'Please Select', 'autocomplete' => 'off']) }}
										</div>
									</div>

<?php
$marital = App\Model\MaritalStatus::pluck('marital_status', 'id')->sortKeys()->toArray();
?>
									<div class="form-group row {{ $errors->has('marital_status_id') ? ' has-error' : '' }}">
										{{ Form::label('marstatus', 'Taraf Perkahwinan : ', ['class' => 'col-sm-2 col-form-label']) }}
										<div class="col-sm-10">
											{{ Form::select('marital_status_id', $marital, @$value, ['class' => 'form-control', 'id' => 'marstatus', 'placeholder' => 'Please Select', 'autocomplete' => 'off']) }}
										</div>
									</div>

									<div class="form-group row {{ $errors->has('mobile') ? ' has-error' : '' }}">
										{{ Form::label('mob', 'Telefon Bimbit : ', ['class' => 'col-sm-2 col-form-label']) }}
										<div class="col-sm-10">
											{{ Form::text('mobile', @$value, ['class' => 'form-control', 'id' => 'mob', 'placeholder' => '0123456789', 'autocomplete' => 'off']) }}
										</div>
									</div>

									<div class="form-group row {{ $errors->has('phone') ? ' has-error' : '' }}">
										{{ Form::label('pho', 'Telefon Tetap : ', ['class' => 'col-sm-2 col-form-label']) }}
										<div class="col-sm-10">
											{{ Form::text('phone', @$value, ['class' => 'form-control', 'id' => 'pho', 'placeholder' => '041234567', 'autocomplete' => 'off']) }}
										</div>
									</div>

									<div class="form-group row {{ $errors->has('dob') ? ' has-error' : '' }}">
										{{ Form::label('dobb', 'Tarikh Lahir : ', ['class' => 'col-sm-2 col-form-label']) }}
										<div class="col-sm-10">
											{{ Form::text('dob', @$value, ['class' => 'form-control', 'id' => 'dobb', 'placeholder' => 'Tarikh Lahir', 'autocomplete' => 'off']) }}
										</div>
									</div>

									<div class="form-group row {{ $errors->has('cimb_account') ? ' has-error' : '' }}">
										{{ Form::label('cimb', 'Akaun CIMB : ', ['class' => 'col-sm-2 col-form-label']) }}
										<div class="col-sm-10">
											{{ Form::text('cimb_account', @$value, ['class' => 'form-control', 'id' => 'cimb', 'placeholder' => '1234567809', 'autocomplete' => 'off']) }}
										</div>
									</div>

									<div class="form-group row {{ $errors->has('epf_no') ? ' has-error' : '' }}">
										{{ Form::label('kwsp', 'Nombor KWSP : ', ['class' => 'col-sm-2 col-form-label']) }}
										<div class="col-sm-10">
											{{ Form::text('epf_no', @$value, ['class' => 'form-control', 'id' => 'kwsp', 'placeholder' => 'Nombor KWSP', 'autocomplete' => 'off']) }}
										</div>
									</div>

									<div class="form-group row {{ $errors->has('income_tax_no') ? ' has-error' : '' }}">
										{{ Form::label('tax', 'Nombor Cukai Pendapatan : ', ['class' => 'col-sm-2 col-form-label']) }}
										<div class="col-sm-10">
											{{ Form::text('income_tax_no', @$value, ['class' => 'form-control', 'id' => 'tax', 'placeholder' => 'Nombor Cukai Pendapatan', 'autocomplete' => 'off']) }}
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
					</div>
				</div>

			</div>
		</div>
