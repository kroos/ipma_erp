<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name=description content="Content">
	<meta name=author content="Author">
	<title>{{ config('app.name') }}</title>
	<link href="{{ asset('images/logo.png') }}" type="image/x-icon" rel="icon" />
	<meta name="keywords" content="" />
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">


	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
	<div id="app">
		@include('layouts.nav')

		<main class="py-4">
			<div class="container-fluid">
				<div class="row justify-content-center">
					<!-- <div class="col-md-12 animated flipInY delay-5s"> -->
					<div class="col-md-12">

						@yield('content')

					</div>
				</div>
			</div>
		</main>
	</div>

	<!-- Scripts -->
	<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
	<script src="https://cdn.ckeditor.com/4.10.0/standard/ckeditor.js"></script>
	<script src="https://cdn.ckeditor.com/4.10.0/standard/adapters/jquery.js"></script>

	<!-- if there is chart involved, uncommented this -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>

	<script type="text/javascript" src="{{ asset('js/ucwords.js') }}" ></script>

	<script type="text/javascript" src="{{ asset('js/datetime-moment.js') }}" ></script>

	@include('layouts.jscript')
</body>
</html>
