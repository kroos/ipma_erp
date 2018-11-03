<div class="card">
	<div class="card-header">Overtime Report</div>
	<div class="card-body table-responsive">

	{!! Form::open( ['route' => ['printpdfovertime.store'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) !!}

		<div class="form-group row {{ $errors->has('half') ? ' has-error' : '' }}">
			{{ Form::label('year', 'Year : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('year', @$value, ['class' => 'form-control', 'id' => 'year', 'placeholder' => 'Year', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('half') ? ' has-error' : '' }}">
			{{ Form::label('half', 'Half Month : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::select('half', [1 => 'First Half', 2 => 'Second Half'], @$value, ['class' => 'form-control', 'id' => 'half', 'placeholder' => 'Please choose', 'autocomplete' => 'off']) }}
			</div>
		</div>
<?php
$loc = \App\Model\Location::all();
?>
		<div class="form-group row {{ $errors->has('location') ? ' has-error' : '' }}">
			{{ Form::label('loc', 'Location : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::select('location', $loc->pluck('location', 'id')->toArray(), @$value, ['class' => 'form-control', 'id' => 'loc', 'placeholder' => 'Please choose', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('month') ? ' has-error' : '' }}">
			{{ Form::label('month', 'Month : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::select('month', [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'Jun', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'], @$value, ['class' => 'form-control', 'id' => 'month', 'placeholder' => 'Please choose', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Print', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	{!! Form::close() !!}

	</div>
	<div class="card-footer">&nbsp;</div>
</div>