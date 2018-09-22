<div class="col-12">
	<div class="card">
		<div class="card-header">
			<h2 class="card-title">Edit Working Hours</h2>
		</div>
		<div class="card-body">

			<div class="form-group row {{ $errors->has('time') ? 'has-error' : '' }}">
				{{ Form::label( 'dstart', 'Time : ', ['class' => 'col-sm-2 col-form-label'] ) }}
				<div class="col-sm-2">
					{{ Form::text('time_start_am', @$value, ['class' => 'form-control', 'id' => 'dstart', 'placeholder' => 'Date Start', 'autocomplete' => 'off']) }}
				</div>
				<div class="col-sm-2">
					{{ Form::text('time_end_am', @$value, ['class' => 'form-control', 'id' => 'dstart', 'placeholder' => 'Date Start', 'autocomplete' => 'off']) }}
				</div>
				<div class="col-sm-2">
					{{ Form::text('time_start_pm', @$value, ['class' => 'form-control', 'id' => 'dstart', 'placeholder' => 'Date Start', 'autocomplete' => 'off']) }}
				</div>
				<div class="col-sm-2">
					{{ Form::text('time_end_pm', @$value, ['class' => 'form-control', 'id' => 'dstart', 'placeholder' => 'Date Start', 'autocomplete' => 'off']) }}
				</div>
			</div>

			<div class="form-group row {{ $errors->has('date') ? 'has-error' : '' }}">
				{{ Form::label( 'dstart', 'Effective Date : ', ['class' => 'col-sm-2 col-form-label'] ) }}
				<div class="col-sm-5">
					{{ Form::text('effective_date_start', @$value, ['class' => 'form-control', 'id' => 'dstart', 'placeholder' => 'Date Start', 'autocomplete' => 'off']) }}
				</div>
				<div class="col-sm-5">
					{{ Form::text('effective_date_end', @$value, ['class' => 'form-control', 'id' => 'dstart', 'placeholder' => 'Date Start', 'autocomplete' => 'off']) }}
				</div>
			</div>

			<div class="form-group row {{ $errors->has('time') ? 'has-error' : '' }}">
				{{ Form::label( 'dstart', 'Remarks : ', ['class' => 'col-sm-2 col-form-label'] ) }}
				<div class="col-sm-10">
					{{ Form::text('remarks', @$value, ['class' => 'form-control', 'id' => 'dstart', 'placeholder' => 'Date Start', 'autocomplete' => 'off', 'disabled' => 'disabled']) }}
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
