<div class="card">
	<div class="card-header">Creating Disciplinary Action to {!! \App\Model\Staff::find(request()->staff_id)->name !!}</div>
	<div class="card-body">

		<div class="form-group row {{ $errors->has('date') ? 'has-error' : '' }}">
			{{ Form::label( 'date', 'Date : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('date', @$value, ['class' => 'form-control form-control-sm', 'id' => 'date', 'placeholder' => 'Date', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('disciplinary_action') ? 'has-error' : '' }}">
			{{ Form::label( 'dc', 'Disciplinary Category : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{!! Form::select('disciplinary_action', \App\Model\DisciplinaryAction::pluck('disciplinary_action', 'id')->toArray(), @$value, ['class' => 'form-control form-control-sm', 'id' => 'dc', 'placeholder' => 'Please choose', 'autocomplete' => 'off']) !!}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('description') ? 'has-error' : '' }}">
			{{ Form::label( 'reason', 'Reason : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::textarea('description', @$value, ['class' => 'form-control form-control-sm', 'id' => 'reason', 'placeholder' => 'Reason', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>
</div>