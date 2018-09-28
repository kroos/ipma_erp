<div class="card">
	<div class="card-header">Edit {{ $staffHR->name }} Profile</div>
	<div class="card-body">

		<div class="form-group row {{ $errors->has('image') ? ' has-error' : '' }}">
			{{ Form::label( 'image', 'Image : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-auto">
				{{ Form::file( 'image', ['class' => 'form-control form-control-file', 'id' => 'image', 'placeholder' => 'Staff Image']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('name')?'has-error':'' }}">
			{{ Form::label( 'hol', 'Name : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('name', @$value, ['class' => 'form-control', 'id' => 'hol', 'placeholder' => 'Name', 'autocomplete' => 'off']) }}
			</div>
		</div>
<?php
$gids = \App\Model\Gender::pluck('gender', 'id')->sortKeys()->toArray();
?>
		<div class="form-group row {{ $errors->has('gender_id')?'has-error':'' }}">
			{{ Form::label( 'gid', 'Gender : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::select( 'gender_id', $gids, @$value, ['class' => 'form-control', 'id' => 'gid', 'placeholder' => 'Please choose', 'autocomplete' => 'off'] ) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('join_at')?'has-error':'' }}">
			{{ Form::label( 'jdate', 'Join Date : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::text('join_at', @$value, ['class' => 'form-control', 'id' => 'jdate', 'placeholder' => 'Join Date', 'autocomplete' => 'off']) }}
			</div>
		</div>
<?php
$lids = \App\Model\Location::pluck('location', 'id')->sortKeys()->toArray();
?>
		<div class="form-group row {{ $errors->has('location_id')?'has-error':'' }}">
			{{ Form::label( 'lid', 'Location : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::select( 'location_id', $lids, @$value, ['class' => 'form-control', 'id' => 'lid', 'placeholder' => 'Please choose', 'autocomplete' => 'off'] ) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('cimb_account') ? ' has-error' : '' }}">
			{{ Form::label('cimb', 'Akaun CIMB : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('cimb_account', @$value, ['class' => 'form-control', 'id' => 'cimb', 'placeholder' => '1234567809', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('epf_no') ? ' has-error' : '' }}">
			{{ Form::label('kwsp', 'Nombor KWSP : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('epf_no', @$value, ['class' => 'form-control', 'id' => 'kwsp', 'placeholder' => 'Nombor KWSP', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('income_tax_no') ? ' has-error' : '' }}">
			{{ Form::label('tax', 'Nombor Cukai Pendapatan : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('income_tax_no', @$value, ['class' => 'form-control', 'id' => 'tax', 'placeholder' => 'Nombor Cukai Pendapatan', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>
	</div>
</div>
