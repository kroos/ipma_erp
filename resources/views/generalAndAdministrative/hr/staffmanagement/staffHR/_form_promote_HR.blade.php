<div class="card">
	<div class="card-header">Promoting {{ $staffHR->name }}</div>
	<div class="card-body">

		<div class="form-group row">
			{{ Form::label('username', 'Staff ID : ', ['class' => ' col-form-label col-form-control-sm col-sm-2']) }}
			<div class="col-sm-10">
				{{ Form::text('username', @$value, ['class' => 'form-control form-control-sm', 'id' => 'username', 'placeholder' => 'Staff ID', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row">
			{{ Form::label('cat', 'Confirmed Date : ', ['class' => 'col-form-label col-form-control-sm col-sm-2']) }}
			<div class="col-sm-10">
				{{ Form::text('confirmed_at', @$value, ['class' => 'form-control form-control-sm', 'id' => 'cat', 'placeholder' => 'Confirmed Date', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row">
			{{ Form::label('al', 'Annual Leave : ', ['class' => ' col-form-label col-form-control-sm col-sm-2']) }}
			<div class="col-sm-10">
				{{ Form::text('annual_leave', ((empty(@$value))?'0':@$value), ['class' => 'form-control form-control-sm', 'id' => 'al', 'placeholder' => 'Annual Leave', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row">
			{{ Form::label('mc', 'Medical Leave : ', ['class' => ' col-form-label col-form-control-sm col-sm-2']) }}
			<div class="col-sm-10">
				{{ Form::text('medical_leave', ((empty(@$value))?'14':@$value), ['class' => 'form-control form-control-sm', 'id' => 'mc', 'placeholder' => 'Medical Leave', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>
</div>