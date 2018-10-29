<?php
use \Carbon\Carbon;
?>
<ul class="nav nav-pills">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('staffTCMS.create') }}">ODBC / CSV Uploader</a>
	</li>
<!-- 	<li class="nav-item">
		<a class="nav-link" href="{{ route('staffTCMS.index') }}">Attendance</a>
	</li> -->
<!-- 	<li class="nav-item">
		<a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="{{ route('leaveList.index') }}">Leave List</a>
		<div class="dropdown-menu">
			<a class="dropdown-item" href="#">Action</a>
			<a class="dropdown-item" href="#">Another action</a>
			<a class="dropdown-item" href="#">Something else here</a>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="#">Separated link</a>
		</div>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="#">check lain function yang ada</a>
	</li> -->
</ul>

<div class="card">
	<div class="card-header">Edit Attendance for {{ $staffTCMS->name }}</div>
	<div class="card-body">

		<dl class="row">
			<dt class="col-sm-3">Staff ID : </dt>
			<dd class="col-sm-9">{{ $staffTCMS->username }}</dd>

			<dt class="col-sm-3">Date : </dt>
			<dd class="col-sm-9">{{ Carbon::parse($staffTCMS->date)->format('D, j F Y') }}</dd>

			<dt class="col-sm-3">Location : </dt>
			<dd class="col-sm-9">{{ $staffTCMS->belongtostaff->belongtolocation->location }}</dd>

			<dt class="col-sm-3">Day Type : </dt>
			<dd class="col-sm-9">{{ $staffTCMS->daytype }}</dd>
		</dl>

		<div class="form-group row {{ $errors->has('in') ? ' has-error' : '' }}">
			{{ Form::label('in', 'In : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('in', @$value, ['class' => 'form-control', 'id' => 'in', 'placeholder' => 'In', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('break') ? ' has-error' : '' }}">
			{{ Form::label('break', 'Break : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('break', @$value, ['class' => 'form-control', 'id' => 'break', 'placeholder' => 'Break', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('resume') ? ' has-error' : '' }}">
			{{ Form::label('resume', 'Resume : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('resume', @$value, ['class' => 'form-control', 'id' => 'resume', 'placeholder' => 'Resume', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('out') ? ' has-error' : '' }}">
			{{ Form::label('out', 'Out : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::text('out', @$value, ['class' => 'form-control', 'id' => 'out', 'placeholder' => 'Out', 'autocomplete' => 'off']) }}
			</div>
		</div>
<?php
$lt = [
			"1/2 Absent" => '1/2 Absent',
			"1/2 AL" => '1/2 AL',
			"1/2 NRL" => '1/2 NRL',
			"1/2 UPL" => '1/2 UPL',
			"ABSENT" => 'ABSENT',
			"AL" => 'AL',
			"AL/UPL" => 'AL/UPL',
			"UPL" => 'UPL',
			"UPL/NRL" => 'UPL/NRL',
			"MC" => 'MC',
			"NRL" => 'NRL',
			"TIME OFF" => 'TIME OFF',
			"EARLY OUT" => 'EARLY OUT',
			"LATE" => 'LATE',
			"MATERNITY" => 'MATERNITY',
			"Outstation" => 'Outstation',
			"SOCSO" => 'SOCSO',
			"UP MEDICAL" => 'UP MEDICAL',
			"" => 'NONE',
];
?>
		<div class="form-group row {{ $errors->has('leave_taken') ? ' has-error' : '' }}">
			{{ Form::label('lt', 'Leave Taken : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::select('leave_taken', $lt, @$value, ['class' => 'form-control', 'id' => 'lt', 'placeholder' => 'Please choose', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('remark') ? ' has-error' : '' }}">
			{{ Form::label('rem', 'Remarks : ', ['class' => 'col-sm-2 col-form-label']) }}
			<div class="col-sm-10">
				{{ Form::textarea('remark', @$value, ['class' => 'form-control', 'id' => 'rem', 'placeholder' => 'Remarks', 'autocomplete' => 'off']) }}
			</div>
		</div>

		<div class="form-group row {{ $errors->has('exception') ? 'has-error' : '' }}">
			<div class="col-sm-10 offset-sm-2">

				<div class="pretty p-icon p-round p-smooth">
					<input type='hidden' value='0' name='exception'>
					{{ Form::checkbox('exception', 1, @$value) }}
					<div class="state p-success">
						<i class="icon mdi mdi-check"></i>
						<label>Exception</label>
					</div>
				</div>

			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Update', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>
</div>






