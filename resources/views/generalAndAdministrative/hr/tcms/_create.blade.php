<?php
use \Carbon\Carbon;
?>
<ul class="nav nav-pills">
	<li class="nav-item">
		<a class="nav-link active" href="{{ route('staffTCMS.create') }}">ODBC / CSV Uploader</a>
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
	<div class="card-header">ODBC Uploader</div>
	<div class="card-body">

		<div class="col-sm-12 jumbotron">
			<img src="{{ asset('images/tcms_capture_odbc.png') }}" alt="TCMS Fingertech ODBC DATA" class="rounded img-fluid mx-auto d-block">
		</div>

		<dl class="row">
			<dt class="col-sm-3">Note : </dt>
			<dd class="col-sm-9">This is ODBC uploader. CSV uploader can also be used depends as user preference.</dd>
		</dl>

		
		{{ Form::open( ['route' => ['staffTCMS.storeODBC'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) }}
			<div class="form-group row">
				<div class="col-sm-10 offset-sm-2">
					{!! Form::button('Update Attendance via ODBC', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
				</div>
			</div>
		{{ Form::close() }}

	</div>
</div>

<p>&nbsp;</p>

<div class="card">
	<div class="card-header">CSV Uploader</div>
	<div class="card-body">


		<div class="col-sm-12 jumbotron">
			<img src="{{ asset('images/tcms_capture_csv.png') }}" alt="TCMS Fingertech CSV DATA" class="rounded img-fluid mx-auto d-block">
		</div>

		<dl class="row">
			<dt class="col-sm-3">Note : </dt>
			<dd class="col-sm-9">This is CSV uploader. ODBC uploader can also be used depends as user preference.</dd>
		</dl>


		{{ Form::open( ['route' => ['staffTCMS.storeCSV'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true]) }}

		<div class="form-group row {{ $errors->has('csv') ? ' has-error' : '' }}">
			{{ Form::label( 'csv', 'Upload CSV File : ', ['class' => 'col-sm-2 col-form-label'] ) }}
			<div class="col-auto">
				{{ Form::file( 'csv', ['class' => 'form-control-file', 'id' => 'csv', 'placeholder' => 'CSV File']) }}
			</div>
		</div>


		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Update Attendance via CSV', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>
		{{ Form::close() }}

	</div>
</div>






