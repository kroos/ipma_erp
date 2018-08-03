@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Dashboard</h1></div>

	<div class="card-body">
		@if (session('status'))
		<div class="alert alert-success" role="alert">
			{{ session('status') }}
		</div>
		@endif

		<p>You are logged in!</p>
	</div>
</div>
@endsection
