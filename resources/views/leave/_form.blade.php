<div class="col-12">
	<div class="card">
		<div class="card-header">
			<h2 class="card-title">Leave Application</h2>
		</div>
		<div class="card-body">

<!-- 						<div class="form-group row {{ $errors->has('children') ? 'has-error' : '' }}">
							{{ Form::label( 'npasa', 'Nama Anak : ', ['class' => 'col-sm-2 col-form-label'] ) }}
							<div class="col-sm-10">
								{{ Form::text('children', @$value, ['class' => 'form-control', 'id' => 'npasa', 'placeholder' => 'Nama Anak', 'autocomplete' => 'off']) }}
							</div>
						</div>
-->

						<div class="form-group row {{ $errors->has('leave_id') ? 'has-error' : '' }}">
							{{ Form::label( 'leave_id', 'Pilih Cuti : ', ['class' => 'col-sm-2 col-form-label'] ) }}
							<div class="col-sm-10">
<?php
$er = App\Model\Leave::all();

// checking for annual leave, mc, nrl and maternity
$ty = \Auth::user()->belongtostaff->gender_id;
// dd($ty);
?>
								<select name="leave_id" id="leave_id" class="form-control" autocomplete="off">
									<option value="">Leave Type</option>
@foreach($er as $lev)
	@if( $ty->gender_id != 2 )
									<option value="{{ $lev->id }}">{{ $lev->leave }}</option>
	@endif
@endforeach
								</select>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group {{ $errors->has('date_time_start') ? 'has-error' : '' }}">
									{{ Form::label('from', 'From : ') }}
									{{ Form::text('date_time_start', @$value, ['class' => 'form-control', 'id' => 'from', 'placeholder' => 'From : ', 'autocomplete' => 'off']) }}
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group {{ $errors->has('date_time_end') ? 'has-error' : '' }}">
									{{ Form::label('to', 'To : ') }}
									{{ Form::text('date_time_end', @$value, ['class' => 'form-control', 'id' => 'to', 'placeholder' => 'To : ', 'autocomplete' => 'off']) }}
								</div>

							</div>
						</div>


						<div class="form-group row {{ $errors->has('leave_id') ? 'has-error' : '' }}">
							{{ Form::label( 'leave', 'Cuti : ', ['class' => 'col-sm-2 col-form-label'] ) }}
							<div class="col-sm-10">
	<?php
	$leave = App\Model\leave::all('leave', 'id');
	?>
								<select name="leave_id" class="form-control" id="leave" autocomplete="off">
									<option value="" >Leave Type</option>
	@foreach($leave as $leav)
		@//if()
									<option value="{{ $leav->id }}" >{{ $leav->leave }}</option>
		@//endif
	@endforeach
								</select>
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
<!-- <div class="col-6">
	<div class="card">
		<div class="card-title"><h2>second column</h2></div>
		<div class="card-body">
			asd
		</div>
		<div class="card-footer">
			asd
		</div>
	</div>
</div> -->