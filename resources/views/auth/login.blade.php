@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>{{ __('Login') }}</h1></div>

	<div class="card-body">
		<form method="POST" action="{{ route('login') }}" id="form" autocomplete="off" enctype="multipart/form-data" aria-label="{{ __('Login') }}">
			@csrf

			<div class="form-group row">
				<label for="username" class="col-sm-4 col-form-label text-md-right">{{ __('Employee ID') }}</label>

				<div class="col-md-6">
					<input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

					@if ($errors->has('username'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('username') }}</strong>
					</span>
					@endif
				</div>
			</div>

			<div class="form-group row">
				<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

				<div class="col-md-6">
					<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

					@if ($errors->has('password'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('password') }}</strong>
					</span>
					@endif
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-6 offset-md-4">
					<div class="form-check">

						<div class="pretty p-switch p-fill">
							<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
							<div class="state">
								<label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group row mb-0">
				<div class="col-md-8 offset-md-4">
					<button type="submit" class="btn btn-primary btn-block">
						{{ __('Login') }}
					</button>

					<a class="btn btn-link" href="{{ route('password.request') }}">
						{{ __('Forgot Your Password?') }}
					</a>
				</div>
			</div>
		</form>
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
// bootstrap validator

$("#form").bootstrapValidator({
	// feedbackIcons: {
	// 	valid: 'fas ',
	// 	invalid: 'fas ',
	// 	validating: 'fas '
	// },
	fields: {
		username: {
			validators: {
				notEmpty: {
					message: 'Please insert employee ID. '
				},
				stringLength: {
					min: 4,
					message: 'The employee ID should be greater than 4. '
				},
				regexp: {
					regexp: /^[a-zA-Z0-9_]+$/,
					message: 'The username can only consist of alphabetical, number and underscore'
				},
			}
		},
		password: {
			validators: {
				notEmpty: {
					message: 'Please insert password. '
				},
				stringLength: {
					min: 4,
					message: 'The password should be greater than 4. '
				},
			}
		},
	}
})


/////////////////////////////////////////////////////////////////////////////////////////
@endsection