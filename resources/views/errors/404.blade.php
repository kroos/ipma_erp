@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Error 404</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<div class="jumbotron ">
			<h1 class="card-title display-4">Oh no, you’ve found our junior developer’s homepage!</h1>
			<h4 class="card-title">Despite sleeping on the couch most of the day, our junior web developer still finds time to do some coding…</h4>
			<img src="{{ asset('images/404.jpg') }}" class="img-fluid rounded" alt="">
			<hr class="my-4">
			<p class="lead">
				<a class="btn btn-primary btn-lg" href="{{ route('main.index') }}" role="button">Back to home</a>
			</p>
		</div>


		
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

