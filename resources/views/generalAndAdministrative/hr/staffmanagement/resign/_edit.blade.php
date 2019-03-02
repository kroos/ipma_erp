<?php
use \App\Model\Staff;

use \Carbon\Carbon;
use \Carbon\CarbonPeriod;

?>
<div class="card">
	<div class="card-header">{!! $staffResign->name !!} Resignation</div>
	<div class="card-body">

		<div class="form-group row {{ $errors->has('resignation_letter_at') ? 'has-error' : '' }}">
			{{ Form::label( 'datl', 'Resignation Letter Date : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('resignation_letter_at', @$value, ['class' => 'form-control form-control-sm', 'id' => 'datl', 'placeholder' => 'Date', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('resign_at') ? 'has-error' : '' }}">
			{{ Form::label( 'datr', 'Resign Date : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('resign_at', @$value, ['class' => 'form-control form-control-sm', 'id' => 'datr', 'placeholder' => 'Date', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>
</div>