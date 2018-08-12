@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Engineering/Research & Development Department</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<ul class="nav nav-tabs">
@foreach( App\Model\Division::find(3)->hasmanydepartment()->get() as $key)
			<li class="nav-item">
				<a class="nav-link {{ ($key->id == 8)? 'active' : '' }}" href="{{ route("$key->route.index") }}">{{ $key->department }}</a>
			</li>
@endforeach
			<li class="nav-item">
				<a class="nav-link disabled" href="#">Disabled</a>
			</li>
		</ul>

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

