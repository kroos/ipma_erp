@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1 class="card-title">Dashboard</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')
		<p>You're logged in</p>
	</div>
</div>
@endsection
