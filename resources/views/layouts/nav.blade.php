<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top navbar-laravel" style="background-color: #e3f2fd;">
	<div class="container">
		<a class="navbar-brand" href="{{ url('/') }}">
			<img src="{{ asset('images/logo2.png') }}" alt="{{ config('app.name') }}" title="{{ config('app.name') }}" class="img-fluid rounded" width="50%">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<!-- Left Side Of Navbar -->
			<ul class="navbar-nav mr-auto"></ul>

			<!-- Right Side Of Navbar -->
			<ul class="navbar-nav ml-auto">
				<!-- Authentication Links -->
			@guest
				<li class="nav-item">
					<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
				</li>
			@else
<?php
$div = App\Model\Division::all();
?>
@foreach($div as $divs)
				<li class="nav-item">
					<a class="nav-link active" href="{{ route("$divs->route.index") }}">{{ $divs->division }}</a>
				</li>
@endforeach
				<li class="nav-item dropdown">
					<a id="navbarDropdown" class="btn btn-info btn-sm nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
						{{ Auth::user()->belongtostaff->name }} <span class="caret"></span>
					</a>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="{{ route('staff.show', Auth::user()->staff_id ) }}">{{ __('Profile') }}</a>

						<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							{{ __('Logout') }}
						</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>

					</div>
				</li>
			@endguest
			</ul>
		</div>
	</div>
</nav>