<div class="card">
	<div class="card-header">Merit for {{ $staffHR->name }}</div>
	<div class="card-body">

		<div class="form-group row {{ $errors->has('discipline_id')?'has-error':'' }}">
			{{ Form::label( 'sid', 'Discipline : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				<select name="discipline_id" id="sid"></select>
			</div>
		</div>

		<div class="form-group row {{ $errors->has('remarks')?'has-error':'' }}">
			{{ Form::label( 'rem', 'Remarks : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::textarea('remarks', @$value, ['class' => 'form-control', 'id' => 'rem', 'placeholder' => 'Remarks', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>
	</div>
</div>
