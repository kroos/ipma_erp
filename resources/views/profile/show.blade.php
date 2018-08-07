@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1 class="card-title">Profile</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<div class="container">
			<div class="card text-center">
				<img class="card-img-top" src="{{ asset('storage/'.$staff->image) }}" alt="Card image cap">
				<h2 class="card-title card-title">{{ $staff->name }}</h2>
				<div class="card-body">
					<div class="row justify-content-center">
						<div class="col-md-6">
							<div class="card">
								<div class="card-header">
									<h2 class="card-title">Butiran</h2>
								</div>
								<div class="card-body">

<?php
function my($string) {
	if (empty($string))	{
		$string = '1900-01-01';		
	}
	$rt = \Carbon\Carbon::createFromFormat('Y-m-d', $string);
	return date('D, d F Y', mktime(0, 0, 0, $rt->month, $rt->day, $rt->year));
}
?>


									<p class="align-left card-text">Status : {{ empty($staff->belongtostatus->status)? 'Not Set' : $staff->belongtostatus->status }}, {{ empty($staff->belongtostatus->code)? '' : $staff->belongtostatus->code }}</p>
									<p class="align-left card-text">Kad Pengenalan : {{ $staff->id_card_passport }}</p>
									<p class="align-left card-text">Agama : {{ empty($staff->belongtoreligion->religion)? 'Not Set' : $staff->belongtoreligion->religion }}</p>
									<p class="align-left card-text">Jantina : {{ empty($staff->belongtogender->gender)? 'Not Set' : $staff->belongtogender->gender }}</p>
									<p class="align-left card-text">Bangsa : {{ empty($staff->belongtorace->race)? 'Not Set' : $staff->belongtorace->race }}</p>
									<p class="align-left card-text">Alamat : {{ empty($staff->address) ? 'Not Set' : $staff->address }}</p>
									<p class="align-left card-text">Tempat Lahir : {{ $staff->place_of_birth }}</p>
									<p class="align-left card-text">Warganegara : {{ empty($staff->belongtocountry->country)? 'Not Set' : $staff->belongtocountry->country }}</p>
									<p class="align-left card-text">Taraf Perkahwinan : {{ empty($staff->belongtomaritalstatus->marital_status)? 'Not Set' : $staff->belongtomaritalstatus->marital_status }}</p>
									<p class="align-left card-text">Telefon Bimbit : {{ $staff->mobile }}</p>
									<p class="align-left card-text">Talian Tetap : {{ $staff->phone }}</p>
									<p class="align-left card-text">Tarikh Lahir : {{ my($staff->dob) }}</p>
									<p class="align-left card-text">Umur : {{ \Carbon\Carbon::parse($staff->dob)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days') }}</p>
									<p class="align-left card-text">Akaun CIMB : {{ $staff->cimb_account }}</p>
									<p class="align-left card-text">Nombor KWSP : {{ $staff->epf_no }}</p>
									<p class="align-left card-text">Nombor Cukai Pendapatan : {{ $staff->income_tax_no }}</p>

								</div>
								<div class="card-footer text-muted">
									<a href="{{ route('staff.edit', $staff->id) }}" class="btn btn-primary">Edit Profile</a>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card">
								<div class="card-header"><h2 class="card-title">nnt lu</h2></div>
								<div class="card-body">
									card body
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
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

