@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1 class="card-title">Profile</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

			<div class="card text-center">
				<div class="col-2 offset-5">
					<img class="card-img-top" src="{{ asset('storage/'.$staff->image) }}" alt="{{ $staff->name }} Image">
				</div>
				<h2 class="card-title card-title">{{ $staff->name }}</h2>
				<div class="card-body">
					<div class="row justify-content-center">
						<div class="col-md-6">
							<div class="card">
								<div class="card-header">
									<h2 class="card-title">Butiran</h2>
								</div>
								<div class="card-body text-left">

<?php
function my($string) {
	if (empty($string))	{
		$string = '1900-01-01';		
	}
	$rt = \Carbon\Carbon::createFromFormat('Y-m-d', $string);
	return date('D, d F Y', mktime(0, 0, 0, $rt->month, $rt->day, $rt->year));
}
?>
									<p class="card-text">Status : {{ empty($staff->belongtostatus->status)? 'Not Set' : $staff->belongtostatus->status }}, {{ empty($staff->belongtostatus->code)? '' : $staff->belongtostatus->code }}</p>
									<p class="card-text">Kad Pengenalan : {{ $staff->id_card_passport }}</p>
									<p class="card-text">Agama : {{ empty($staff->belongtoreligion->religion)? 'Not Set' : $staff->belongtoreligion->religion }}</p>
									<p class="card-text">Jantina : {{ empty($staff->belongtogender->gender)? 'Not Set' : $staff->belongtogender->gender }}</p>
									<p class="card-text">Bangsa : {{ empty($staff->belongtorace->race)? 'Not Set' : $staff->belongtorace->race }}</p>
									<p class="card-text">Alamat : {{ empty($staff->address) ? 'Not Set' : $staff->address }}</p>
									<p class="card-text">Tempat Lahir : {{ $staff->place_of_birth }}</p>
									<p class="card-text">Warganegara : {{ empty($staff->belongtocountry->country)? 'Not Set' : $staff->belongtocountry->country }}</p>
									<p class="card-text">Taraf Perkahwinan : {{ empty($staff->belongtomaritalstatus->marital_status)? 'Not Set' : $staff->belongtomaritalstatus->marital_status }}</p>
									<p class="card-text">Telefon Bimbit : {{ $staff->mobile }}</p>
									<p class="card-text">Talian Tetap : {{ $staff->phone }}</p>
									<p class="card-text">Tarikh Lahir : {{ my($staff->dob) }}</p>
									<p class="card-text">Umur : {{ \Carbon\Carbon::parse($staff->dob)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days') }}</p>
									<p class="card-text">Akaun CIMB : {{ $staff->cimb_account }}</p>
									<p class="card-text">Nombor KWSP : {{ $staff->epf_no }}</p>
									<p class="card-text">Nombor Cukai Pendapatan : {{ $staff->income_tax_no }}</p>

								</div>
								<div class="card-footer text-muted">
									<a href="{{ route('staff.edit', $staff->id) }}" class="btn btn-primary">Edit Profile</a>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card">
								<div class="card-header"><h2 class="card-title">Keluarga (Family And Siblings)</h2></div>
								<div class="card-body text-center table-responsive">

<?php
$sib = \App\Model\StaffSibling::where('staff_id', $staff->id)->orderBy('dob')->get();
?>
									<div class="col">
										<h4 class="card-title">Saudara Kandung</h4>
										@if($sib->count() > 0 )
										<table class="table table-hover">
											<thead>
												<tr>
													<th scope="col">#</th>
													<th scope="col">Nama</th>
													<th scope="col">Telefon</th>
													<th scope="col">Umur</th>
													<th scope="col">Pekerjaan</th>
												</tr>
											</thead>
											<tbody>
												@foreach($sib as $sibl)
												<tr>
													<td>
														<a href="{!! route('staffSibling.edit', $sibl->id) !!}" title="Edit"><i class="fas fa-pen-square fa-lg" aria-hidden="true"></i></a>

														<a href="{!! route('staffSibling.destroy', $sibl->id) !!}" data-id="{!! $sibl->id !!}" data-token="{{ csrf_token() }}" id="delete_sibling_<?=$sibl->id ?>" title="Delete" class="delete_sibling"><i class="fas fa-trash fa-lg" aria-hidden="true"></i></a>
													</td>
													<td>{{ $sibl->sibling }}</td>
													<td>{{ $sibl->phone }}</td>
													<td>{{ \Carbon\Carbon::parse($sibl->dob)->diff(\Carbon\Carbon::now())->format('%y years') }}</td>
													<td>{{ $sibl->profession }}</td>
												</tr>
												@endforeach
											</tbody>
										</table>
										@else
										<p class="card-text text-justify">Sorry, no record for your sibling. Please fill this form by clicking "Add Sibling"</p>
										@endif
										<p class="card-text text-center"><a href="{{ route('staffSibling.create') }}" class="btn btn-primary">Add Sibling</a></p>
									</div>
<hr>
									<p>&nbsp;</p>
@if($staff->marital_status_id != 1)
<?php
$spo = \App\Model\StaffSpouse::where('staff_id', $staff->id)->orderBy('dob')->get();
?>
									<div class="col">
										<h4 class="card-title">Pasangan</h4>
										@if($spo->count() > 0 )
										<table class="table table-hover">
											<thead>
												<tr>
													<th scope="col">#</th>
													<th scope="col">Pasangan</th>
													<th scope="col">ID Kad</th>
													<th scope="col">Telefon</th>
													<th scope="col">Umur</th>
													<th scope="col">Pekerjaan</th>
												</tr>
											</thead>
											<tbody>
												@foreach($spo as $spou)
												<tr>
													<td>
														<a href="{!! route('staffSpouse.edit', $spou->id) !!}" title="Edit"><i class="fas fa-pen-square fa-lg" aria-hidden="true"></i></a>

														<a href="{!! route('staffSpouse.destroy', $spou->id) !!}" data-id="{!! $spou->id !!}" data-token="{{ csrf_token() }}" id="delete_spouse_<?=$spou->id ?>" title="Delete" class="delete_spouse"><i class="fas fa-trash fa-lg" aria-hidden="true"></i></a>
													</td>
													<td>{{ $spou->spouse }}</td>
													<td>{{ $spou->id_card_passport }}</td>
													<td>{{ $spou->phone }}</td>
													<td>{{ \Carbon\Carbon::parse($spou->dob)->diff(\Carbon\Carbon::now())->format('%y years') }}</td>
													<td>{{ $spou->profession }}</td>
												</tr>
												@endforeach
											</tbody>
										</table>
										@else
										<p class="card-text text-justify">Sorry, no record for your spouse. Please fill this form by clicking "Add Spouse"</p>
										@endif
										<p class="card-text text-center"><a href="{{ route('staffSpouse.create') }}" class="btn btn-primary">Add Spouse</a></p>
									</div>
<hr>
									<p>&nbsp;</p>
<?php
$chi = \App\Model\StaffChildren::where('staff_id', $staff->id)->orderBy('dob')->get();
?>
									<div class="col">
										<h4 class="card-title">Anak</h4>
										@if($chi->count() > 0 )
										<table class="table table-hover">
											<thead>
												<tr>
													<th scope="col">#</th>
													<th scope="col">Anak</th>
													<th scope="col">Umur</th>
													<th scope="col">Jantina</th>
													<th scope="col">Tahap Pengajian</th>
													<th scope="col">Kesihatan</th>
													<th scope="col">Pengecualian Cukai</th>
													<th scope="col">Peratus Pengecualian Cukai</th>
												</tr>
											</thead>
											<tbody>
												@foreach($chi as $chil)
												<tr>
													<td>
														<a href="{!! route('staffChildren.edit', $chil->id) !!}" title="Edit"><i class="fas fa-pen-square fa-lg" aria-hidden="true"></i></a>

														<a href="{!! route('staffChildren.destroy', $chil->id) !!}" data-id="{{ $chil->id }}" data-token="{{ csrf_token() }}" id="delete_children_{{ $chil->id }}" title="Delete" class="delete_children"><i class="fas fa-trash fa-lg" aria-hidden="true"></i></a>
													</td>
													<td>{{ $chil->children }}</td>
													<td>{{ \Carbon\Carbon::parse($chil->dob)->diff(\Carbon\Carbon::now())->format('%y years') }}</td>
													<td>{{ $chil->belongtogender->gender }}</td>
													<td>{{ $chil->belongtoeducationlevel->education_level }}</td>
													<td>{{ $chil->belongtohealthstatus->health_status }}</td>
													<td>{{ ($chil->tax_exemption != 0)? 'Ya' : 'Tidak' }}</td>
													<td>{{ !isset($chil->tax_exemption_percentage_id) ? '' : $chil->belongtotaxexemptionpercentage->tax_exemption_percentage }}</td>
												</tr>
												@endforeach
											</tbody>
										</table>
										@else
										<p class="card-text text-justify">Sorry, no record for your children. Please fill this form by clicking "Add Children"</p>
										@endif
										<p class="card-text text-center"><a href="{{ route('staffChildren.create') }}" class="btn btn-primary">Add Children</a></p>
									</div>
<hr>
									<p>&nbsp;</p>



@endif
								</div>
								<div class="card-footer text-muted">
									<!-- <a href="{{ route('staff.edit', $staff->id) }}" class="btn btn-primary">Edit Family</a> -->
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
// sweetalert2 delete spouse
$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
});

$(document).on('click', '.delete_spouse', function(e){
	var productId = $(this).data('id');
	SwalDelete(productId);
	e.preventDefault();
});

function SwalDelete(productId){
	swal({
		title: 'Are you sure?',
		text: "It will be deleted permanently!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!',
		showLoaderOnConfirm: true,
		allowOutsideClick: false,

		preConfirm: function()                {
			return new Promise(function(resolve) {
				$.ajax({
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					url: '{{ url('staffSpouse') }}' + '/' + productId,
					type: 'DELETE',
					data:	{
								id: productId,
								_token : $('meta[name=csrf-token]').attr('content')
							},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status);
					$('#delete_spouse_' + productId).parent().parent().remove();
				})
				.fail(function(){
					swal('Oops...', 'Something went wrong with ajax!', 'error');
				});
			});
		},
	})
	.then((result) => {
		if(result.dismiss === swal.DismissReason.cancel) {
			swal('Cancelled', 'Your data is safe', 'info');
		}
	});
}

/////////////////////////////////////////////////////////////////////////////////////////
// sweetalert2 delete sibling

$(document).on('click', '.delete_sibling', function(e){
	var siblingID = $(this).data('id');
	SwalDeletesibling(siblingID);
	e.preventDefault();
});

function SwalDeletesibling(siblingID){
	swal({
		title: 'Are you sure?',
		text: "It will be deleted permanently!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!',
		showLoaderOnConfirm: true,
		allowOutsideClick: false,

		preConfirm: function()                {
			return new Promise(function(resolve) {
				$.ajax({
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					url: '{{ url('staffSibling') }}' + '/' + siblingID,
					type: 'DELETE',
					data:	{
								id: siblingID,
								_token : $('meta[name=csrf-token]').attr('content')
							},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status);
					$('#delete_sibling_' + siblingID).parent().parent().remove();
				})
				.fail(function(){
					swal('Oops...', 'Something went wrong with ajax!', 'error');
				});
			});
		},
	})
	.then((result) => {
		if(result.dismiss === swal.DismissReason.cancel) {
			swal('Cancelled', 'Your data is safe', 'info');
		}
	});
}

/////////////////////////////////////////////////////////////////////////////////////////
// sweetalert2 delete children

$(document).on('click', '.delete_children', function(e){
	var childrenID = $(this).data('id');
	SwalDeletechildren(childrenID);
	e.preventDefault();
});

function SwalDeletechildren(childrenID){
	swal({
		title: 'Are you sure?',
		text: "It will be deleted permanently!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!',
		showLoaderOnConfirm: true,
		allowOutsideClick: false,

		preConfirm: function()                {
			return new Promise(function(resolve) {
				$.ajax({
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					url: '{{ url('staffChildren') }}' + '/' + childrenID,
					type: 'DELETE',
					data:	{
								id: childrenID,
								_token : $('meta[name=csrf-token]').attr('content')
							},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status);
					$('#delete_children_' + childrenID).parent().parent().remove();
				})
				.fail(function(){
					swal('Oops...', 'Something went wrong with ajax!', 'error');
				});
			});
		},
	})
	.then((result) => {
		if(result.dismiss === swal.DismissReason.cancel) {
			swal('Cancelled', 'Your data is safe', 'info');
		}
	});
}

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

@endsection

