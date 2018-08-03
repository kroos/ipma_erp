@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Profile</h1></div>
	<div class="card-body">
		@include('layout.info')
		@include('layout.errorform')


		
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

