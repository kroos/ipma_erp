<div class="card">
	<div class="card-header">
		<h2 class="card-title">Add Staff</h2>
	</div>
	<div class="card-body">

		<div class="form-group row {{ $errors->has('name')?'has-error':'' }}">
			{{ Form::label( 'hol', 'Name : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('name', @$value, ['class' => 'form-control', 'id' => 'hol', 'placeholder' => 'Name', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('username')?'has-error':'' }}">
			{{ Form::label( 'uid', 'User ID : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('username', @$value, ['class' => 'form-control', 'id' => 'uid', 'placeholder' => 'User ID', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('password')?'has-error':'' }}">
			{{ Form::label( 'uid', 'Password : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('password', @$value, ['class' => 'form-control', 'id' => 'uid', 'placeholder' => 'Password', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>
	</div>
</div>
