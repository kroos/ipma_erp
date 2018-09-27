<div class="card">
	<div class="card-header">Edit {{ $staffHR->name }} Profile</div>
	<div class="card-body">

		<div class="form-group row {{ $errors->has('image') ? ' has-error' : '' }}">
			{{ Form::label( 'image', 'Image : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-auto">
				{{ Form::file( 'image', ['class' => 'form-control form-control-file', 'id' => 'image', 'placeholder' => 'Your Image']) }}
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

		<div class="form-group row {{ $errors->has('join_date')?'has-error':'' }}">
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














<?php
$divs = \App\Model\Division::pluck('division', 'id')->sortKeys()->toArray();
$depts = \App\Model\Department::all();
$poss = \App\Model\Position::all();
$valdiv = $staffHR->belongtomanyposition()->wherePivot('main', 1)->first()->division_id ;
$valdept = $staffHR->belongtomanyposition()->wherePivot('main', 1)->first()->department_id ;
$valpos = $staffHR->belongtomanyposition()->wherePivot('main', 1)->first()->id ;
?>
		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-m-6">
					{{ Form::select( 'division_id', $divs, @$valdiv, ['class' => 'form-control', 'id' => 'divid', 'placeholder' => 'Please choose', 'autocomplete' => 'off'] ) }}
					<select name="department_id" id="deptid" class="form-control">
@foreach($depts as $de)
						<option value="{{ $de->id }}" data-chained="{{ $de->division_id }}" {{ ($de->id == $valdept)?'selected':'' }}>{{ $de->department }}</option>
@endforeach
					</select>
				<select name="position_id" id="posid" class="form-control">
@foreach($poss as $po)
					<option value="{{ $po->id }}" data-chained="{{ $po->department_id }}" {{ ($po->id == $valpos)?'selected':'' }}>{{ $po->position }}</option>
@endforeach
				</select>
				</div>
				<div class="col-m-6">
					
				</div>
			</div>
		</div>

		<div class="form-group row {{ $errors->has('division_id')?'has-error':'' }}">
			{{ Form::label( 'divid', 'Division : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				{{ Form::select( 'division_id', $divs, @$valdiv, ['class' => 'form-control', 'id' => 'divid', 'placeholder' => 'Please choose', 'autocomplete' => 'off'] ) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('department_id')?'has-error':'' }}">
			{{ Form::label( 'deptid', 'Department : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				<select name="department_id" id="deptid" class="form-control">
@foreach($depts as $de)
					<option value="{{ $de->id }}" data-chained="{{ $de->division_id }}" {{ ($de->id == $valdept)?'selected':'' }}>{{ $de->department }}</option>
@endforeach
				</select>
			</div>
		</div>

		<div class="form-group row {{ $errors->has('position_id')?'has-error':'' }}">
			{{ Form::label( 'posid', 'Main Position : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-sm-10">
				<select name="position_id" id="posid" class="form-control">
@foreach($poss as $po)
					<option value="{{ $po->id }}" data-chained="{{ $po->department_id }}" {{ ($po->id == $valpos)?'selected':'' }}>{{ $po->position }}</option>
@endforeach
				</select>
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>
	</div>
</div>
