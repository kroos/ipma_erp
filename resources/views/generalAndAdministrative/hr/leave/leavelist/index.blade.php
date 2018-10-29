@extends('layouts.app')

@section('content')

<ul class="nav nav-tabs">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('leaveSetting.index') }}">Settings</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('leaveNRL.index') }}">Non Replacement Leave</a>
	</li>
<!-- 	<li class="nav-item">
		<a class="nav-link dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="{{ route('leaveList.index') }}">Leave List</a>
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
	<div class="card-header">Edit Leave For </div>
	<div class="card-body">
		include
	</div>
</div>

@endsection

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//ucwords
$("#username").keyup(function() {
	uch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

