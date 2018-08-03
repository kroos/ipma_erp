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
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" /> -->
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/css/dataTables.bootstrap4.css" /> -->

</head>
<body>
	<div id="app">
		@include('layouts.nav')

		<main class="py-4">
			<div class="container">
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

	<!-- Scripts -->
	<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
	<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" ></script> -->
	<!-- <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" ></script> -->

	<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.js"></script> -->

	<!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> -->
	<!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script> -->
	
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script> -->
	<!-- <script type="text/javascript" src="https://unpkg.com/sweetalert2@7.22.0/dist/sweetalert2.all.js" ></script> -->
	<!-- <script src="{{ asset('js/bootstrapValidator.js') }}" type="text/javascript" ></script> -->

	<!-- <script type="text/javascript" src="{{ asset('js/jquery.js') }}" ></script> -->
	<!-- <script type="text/javascript" src="{{ asset('js/popper.js') }}" ></script> -->
	<!-- <script type="text/javascript" src="{{ asset('js/popper-utils.js') }}" ></script> -->
	<!-- <script type="text/javascript" src="{{ asset('js/bootstrap.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('js/carousel-swipe.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('js/jquery.dataTables.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('js/dataTables.bootstrap4.js') }}" ></script> -->
	<!-- <script type="text/javascript" src="{{ asset('js/responsive.bootstrap4.js') }}" ></script> -->
	<!-- <script type="text/javascript" src="{{ asset('js/jquery.chained.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('js/jquery.chained.remote.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('js/jquery.cookie.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('js/moment.min.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('js/select2.full.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('js/tether.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('js/jquery.minicolors.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('js/jarallax.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('js/jarallax-element.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('js/jarallax-video.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('js/sweetalert2.all.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('js/bootstrapValidator.js') }}" ></script> -->
	<!-- <script type="text/javascript" src="{{ asset('js/jquery-ui.js') }}" ></script> -->

	<!-- if there is chart involved, uncommented this -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>

	<script type="text/javascript" src="{{ asset('js/ucwords.js') }}" ></script>

	@include('layouts.jscript')
</body>
</html>
