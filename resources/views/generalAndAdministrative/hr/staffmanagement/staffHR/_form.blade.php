<div class="card">
	<div class="card-header">Add Staff</div>
	<div class="card-body">

		<div class="form-group row {{ $errors->has('image') ? ' has-error' : '' }}">
			{{ Form::label( 'image', 'Image : ', ['class' => 'col-sm-2'] ) }}
			<div class="col-sm-10">
				{{ Form::file( 'image', ['class' => 'form-control-file', 'id' => 'image']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('name')?'has-error':'' }}">
			{{ Form::label( 'hol', 'Name : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('name', @$value, ['class' => 'form-control', 'id' => 'hol', 'placeholder' => 'Name', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('status_id')?'has-error':'' }}">
			{{ Form::label( 'sid', 'Status : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				<select name="status_id" id="sid"></select>
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

		<div class="form-group row {{ $errors->has('gender_id')?'has-error':'' }}">
			{{ Form::label( 'gid', 'Gender : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				<select name="gender_id" id="gid"></select>
			</div>
		</div>

		<div class="form-group row {{ $errors->has('join_date')?'has-error':'' }}">
			{{ Form::label( 'jdate', 'Join Date : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('join_at', @$value, ['class' => 'form-control', 'id' => 'jdate', 'placeholder' => 'Join Date', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('dob')?'has-error':'' }}">
			{{ Form::label( 'dob', 'Date Of Birth : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('dob', @$value, ['class' => 'form-control', 'id' => 'dob', 'placeholder' => 'Date Of Birth', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('location_id')?'has-error':'' }}">
			{{ Form::label( 'lid', 'Location : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				<select name="location_id" id="lid"></select>
			</div>
		</div>
<?php
$divs = \App\Model\Division::pluck('division', 'id')->sortKeys()->toArray();
?>
		<div class="form-group row {{ $errors->has('division_id')?'has-error':'' }}">
			{{ Form::label( 'divid', 'Division : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::select( 'division_id', $divs, @$value, ['class' => 'form-control col-sm-12', 'id' => 'divid', 'placeholder' => 'Please choose', 'autocomplete' => 'off'] ) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('department_id')?'has-error':'' }}">
			{{ Form::label( 'deptid', 'Department : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				<select name="department_id" id="deptid" class="form-control col-sm-12" autocomplete="off"></select>
			</div>
		</div>

		<div class="form-group row {{ $errors->has('position_id')?'has-error':'' }}">
			{{ Form::label( 'posid', 'Main Position : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				<select name="position_id" id="posid" class="form-control col-sm-12" autocomplete="off"></select>
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">

				<div class="pretty p-icon p-round p-smooth">
					<input type='hidden' value='0' name='leave_need_backup'>
					{{ Form::checkbox('leave_need_backup', 1, @$value) }}
					<div class="state p-success">
						<i class="icon mdi mdi-check"></i>
						<label>This User Need Backup?</label>
					</div>
				</div>

			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>
	</div>
</div>
