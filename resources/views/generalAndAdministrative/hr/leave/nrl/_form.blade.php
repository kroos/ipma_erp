<?php
use \Carbon\Carbon;
use \App\Model\StaffLeaveReplacement;
use \App\Model\Staff;
use \App\Model\StaffLeave;

$now = Carbon::now();

$sid = Staff::where('active', 1)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
?>
<ul class="nav nav-pills">
	<li class="nav-item">
		<a class="nav-link " href="{{ route('leaveSetting.index') }}">Settings</a>
	</li>
	<li class="nav-item">
		<a class="nav-link active" href="{{ route('leaveNRL.index') }}">Non Replacement Leave</a>
	</li>
	<li class="nav-item">
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
	</li>
</ul>

<div class="card">
	<div class="card-header">Add New Replacement Leave</div>
	<div class="card-body table-responsive">
		@include('layouts.info')
		@include('layouts.errorform')

		<div class="container-fluid rl_wrap">
		</div>

		<div class="row col-lg-12">
			<p>
				<button class="btn btn-primary add_rl" type="button">
					<i class="fas fa-plus" aria-hidden="true"></i>&nbsp;Add Replacement Leave
				</button>
			</p>
		</div>

		<div class="row col-lg-12">
			<p>To begin, please click button "<strong>Add Replacement Leave</strong>"</p>
		</div>

		

		<div class="form-group row">
			<div class="col-sm-10 offset-sm-2">
				{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
			</div>
		</div>

	</div>
</div>