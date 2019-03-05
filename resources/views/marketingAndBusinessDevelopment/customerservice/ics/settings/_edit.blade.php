<div class="card">
	<div class="card-header">Edit Service Report Constant</div>
	<div class="card-body">

		<div class="form-group row {{ $errors->has('overtime_constant_1')?'has-error':'' }}">
			{{ Form::label( 'oc1', 'Overtime Constant 1 : ', ['class' => 'col-sm-4 col-form-label'] ) }}
			<div class="col-sm-8">
				{!! Form::text('overtime_constant_1', @$value, ['class' => 'form-control form-control-sm col-2', 'id' => 'oc1', 'placeholder' => 'Overtime Constant 1', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('overtime_constant_2')?'has-error':'' }}">
			{{ Form::label( 'oc2', 'Overtime Constant 2 : ', ['class' => 'col-sm-4 col-form-label'] ) }}
			<div class="col-sm-8">
				{!! Form::text('overtime_constant_2', @$value, ['class' => 'form-control form-control-sm col', 'id' => 'oc2', 'placeholder' => 'Overtime Constant 2', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('accomodation_rate')?'has-error':'' }}">
			{{ Form::label( 'ar', 'Accomodation Rate : ', ['class' => 'col-sm-4 col-form-label'] ) }}
			<div class="col-sm-8">
				{!! Form::text('accomodation_rate', @$value, ['class' => 'form-control form-control-sm col', 'id' => 'ar', 'placeholder' => 'Accomodation Rate', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('travel_meter_rate')?'has-error':'' }}">
			{{ Form::label( 'mr', 'Mileage Rate : ', ['class' => 'col-sm-4 col-form-label'] ) }}
			<div class="col-sm-8">
				{!! Form::text('travel_meter_rate', @$value, ['class' => 'form-control form-control-sm col', 'id' => 'mr', 'placeholder' => 'Mileage Rate', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('travel_hour_rate')?'has-error':'' }}">
			{{ Form::label( 'hr', 'Hour Rate : ', ['class' => 'col-sm-4 col-form-label'] ) }}
			<div class="col-sm-8">
				{!! Form::text('travel_hour_rate', @$value, ['class' => 'form-control form-control-sm col', 'id' => 'hr', 'placeholder' => 'Hour Rate', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>
</div>