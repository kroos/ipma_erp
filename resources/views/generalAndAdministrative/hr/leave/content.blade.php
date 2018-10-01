@section('content1')
<ul class="nav nav-pills">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('leaveSetting.index') }}">Settings</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('leaveList.index') }}">Leave List</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('leaveNRL.index') }}">Non Replacement Leave</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="#">check lain function yang ada</a>
	</li>
</ul>


@show