<div class="form-group row {{ $errors->has('oldPassword') ? 'has-error' : '' }}">
	{{ Form::label('oldpass', 'Current Password :', ['class' => 'col-sm-2 col-form-label']) }}
	<div class="col-sm-10">
		{!! Form::password( 'oldPassword', ['class' => 'form-control', 'id' => 'oldpass', 'autocomplete' => 'off', 'placeholder' => 'Current Password']) !!}
	</div>
</div>

<div class="form-group row {{ $errors->has('newPassword') ? 'has-error' : '' }}">
	{{ Form::label('newpass', 'New Password :', ['class' => 'col-sm-2 col-form-label']) }}
	<div class="col-sm-10">
		{{ Form::password('newPassword', ['class' => 'form-control', 'id' => 'newpass', 'autocomplete' => 'off', 'placeholder' => 'New Password']) }}
	</div>
</div>

<div class="form-group row {{ $errors->has('newPassword_confirmation') ? 'has-error' : '' }}">
	{{ Form::label('pass', 'Confirm New Password :', ['class' => 'col-sm-2 col-form-label']) }}
	<div class="col-sm-10">
		{{ Form::password('newPassword_confirmation', ['class' => 'form-control', 'id' => 'pass', 'autocomplete' => 'off', 'placeholder' => 'Confirm New Password']) }}
	</div>
</div>

<div class="form-group row">
	<div class="col-sm-10 offset-sm-2">
		{{ Form::button('Change Password', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) }}
	</div>
</div>


