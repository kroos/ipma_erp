@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1 class="card-title">Profile</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

			<div class="card text-center">
				<div class="col-2 offset-5">
					<img class="card-img-top rounded" src="{{ asset('storage/'.$staff->image) }}" alt="{{ $staff->name }} Image">
				</div>
				<h2 class="card-title card-title">{{ $staff->name }}</h2>
				<div class="card-body">
					<div class="row justify-content-center">
						<div class="col-lg-5">
							<div class="card">
								<div class="card-header">
									<h2 class="card-title">Butiran</h2>
								</div>
								<div class="card-body text-left table-responsive">
<?php
function my($string) {
	if (empty($string))	{
		$string = '1900-01-01';		
	}
	$rt = \Carbon\Carbon::createFromFormat('Y-m-d', $string);
	return date('D, d F Y', mktime(0, 0, 0, $rt->month, $rt->day, $rt->year));
}
?>

								<table class="table table-hover">
									<tbody>
										<tr>
											<td scope="col">Status :</td>
											<td scope="col">{{ empty($staff->belongtostatus->status)? 'Not Set' : $staff->belongtostatus->status }}, {{ empty($staff->belongtostatus->code)? '' : $staff->belongtostatus->code }}</td>
										</tr>
										<tr>
											<td scope="col">ID Pekerja :</td>
											<td scope="col">{{ empty($staff->hasmanylogin()->where('active', 1)->first()->username)?'Not Set':$staff->hasmanylogin()->where('active', 1)->first()->username }}</td>
										</tr>
@foreach( \Auth::user()->belongtostaff->belongtomanyposition()->orderBy('staff_positions.main', 'desc')->get() as $val )
										<tr>
											<td class="{{ ($val->pivot->main == 1)?'border border-primary':'' }}" scope="col">Kategori :</td>
											<td class="{{ ($val->pivot->main == 1)?'border border-primary':'' }}" scope="col">{{ empty($val->id)?'Not Set':$val->belongtocategory->category }}</td>
										</tr>
										<tr>
											<td class="{{ ($val->pivot->main == 1)?'border border-primary':'' }}" scope="col">Divisi :</td>
											<td class="{{ ($val->pivot->main == 1)?'border border-primary':'' }}" scope="col">{{ empty($val->id)?'Not Set':$val->belongtodivision->division }}</td>
										</tr>
										<tr>
											<td class="{{ ($val->pivot->main == 1)?'border border-primary':'' }}" scope="col">Jabatan :</td>
											<td class="{{ ($val->pivot->main == 1)?'border border-primary':'' }}" scope="col">{{ empty($val->id)?'Not Set': empty($val->department_id)?'': $val->belongtodepartment->department }}</td>
										</tr>
										<tr>
											<td class="{{ ($val->pivot->main == 1)?'border border-primary':'' }}" scope="col">Jawatan :</td>
											<td class="{{ ($val->pivot->main == 1)?'border border-primary':'' }}" scope="col">{{ empty($val->id)?'Not Set':$val->position }}</td>
										</tr>
@endforeach
										<tr>
											<td scope="col">Lokasi :</td>
											<td scope="col">{{ empty($staff->location_id)?'Not Set':$staff->belongtolocation->location }}</td>
										</tr>
										<tr>
											<td scope="col">Email :</td>
											<td scope="col">{{ $staff->email }}</td>
										</tr>
										<tr>
											<td scope="col">Kad Pengenalan :</td>
											<td scope="col">{{ $staff->id_card_passport }}</td>
										</tr>
										<tr>
											<td scope="col">Agama :</td>
											<td scope="col">{{ empty($staff->belongtoreligion->religion)? 'Not Set' : $staff->belongtoreligion->religion }}</td>
										</tr>
										<tr>
											<td scope="col">Lesen Memandu :</td>
											<td scope="col">
												<table>
													<tbody>
<?php
$dr = \App\Model\StaffDrivingLicense::where('staff_id', $staff->id)->orderBy('id')->get();
?>
@foreach($dr as $drv)
														<tr>
															<td>{{ $drv->belongtodrivinglicense->class }} => {{ $drv->belongtodrivinglicense->description }}</td>
														</tr>
@endforeach														
													</tbody>
												</table>
											</td>
										</tr>
										<tr>
											<td>Jantina :</td>
											<td>{{ empty($staff->belongtogender->gender)? 'Not Set' : $staff->belongtogender->gender }}</td>
										</tr>
										<tr>
											<td>Bangsa :</td>
											<td>{{ empty($staff->belongtorace->race)? 'Not Set' : $staff->belongtorace->race }}</td>
										</tr>
										<tr>
											<td>Alamat :</td>
											<td>{{ empty($staff->address) ? 'Not Set' : $staff->address }}</td>
										</tr>
										<tr>
											<td>Tempat Lahir :</td>
											<td>{{ $staff->place_of_birth }}</td>
										</tr>
										<tr>
											<td>Warganegara :</td>
											<td>{{ empty($staff->belongtocountry->country)? 'Not Set' : $staff->belongtocountry->country }}</td>
										</tr>
										<tr>
											<td>Taraf Perkahwinan :</td>
											<td>{{ empty($staff->belongtomaritalstatus->marital_status)? 'Not Set' : $staff->belongtomaritalstatus->marital_status }}</td>
										</tr>
										<tr>
											<td>Telefon Bimbit :</td>
											<td>{{ $staff->mobile }}</td>
										</tr>
										<tr>
											<td>Talian Tetap :</td>
											<td>{{ $staff->phone }}</td>
										</tr>
										<tr>
											<td>Tarikh Lahir :</td>
											<td>{{ my($staff->dob) }}</td>
										</tr>
										<tr>
											<td>Umur :</td>
											<td>{{ \Carbon\Carbon::parse($staff->dob)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days') }}</td>
										</tr>
										<tr>
											<td>Akaun CIMB :</td>
											<td>{{ $staff->cimb_account }}</td>
										</tr>
										<tr>
											<td>Akaun KWSP :</td>
											<td>{{ $staff->epf_no }}</td>
										</tr>
										<tr>
											<td>Nombor Cukai Pendapatan :</td>
											<td>{{ $staff->income_tax_no }}</td>
										</tr>
									</tbody>
								</table>

								</div>
								<div class="card-footer text-muted">
									<a href="{{ route('staff.edit', $staff->id) }}" class="btn btn-primary">Edit Profile</a>
								</div>
							</div>
						</div>
						<div class="col-lg-7">
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
													<td scope="col">{{ $sibl->sibling }}</td>
													<td scope="col">{{ $sibl->phone }}</td>
													<td scope="col">{{ \Carbon\Carbon::parse($sibl->dob)->diff(\Carbon\Carbon::now())->format('%y years') }}</td>
													<td scope="col">{{ $sibl->profession }}</td>
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
													<td scope="col">
														<a href="{!! route('staffSpouse.edit', $spou->id) !!}" title="Edit"><i class="fas fa-pen-square fa-lg" aria-hidden="true"></i></a>

														<a href="{!! route('staffSpouse.destroy', $spou->id) !!}" data-id="{!! $spou->id !!}" data-token="{{ csrf_token() }}" id="delete_spouse_<?=$spou->id ?>" title="Delete" class="delete_spouse"><i class="fas fa-trash fa-lg" aria-hidden="true"></i></a>
													</td>
													<td scope="col">{{ $spou->spouse }}</td>
													<td scope="col">{{ $spou->id_card_passport }}</td>
													<td scope="col">{{ $spou->phone }}</td>
													<td scope="col">{{ \Carbon\Carbon::parse($spou->dob)->diff(\Carbon\Carbon::now())->format('%y years') }}</td>
													<td scope="col">{{ $spou->profession }}</td>
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
													<td scope="col">
														<a href="{!! route('staffChildren.edit', $chil->id) !!}" title="Edit"><i class="fas fa-pen-square fa-lg" aria-hidden="true"></i></a>

														<a href="{!! route('staffChildren.destroy', $chil->id) !!}" data-id="{{ $chil->id }}" data-token="{{ csrf_token() }}" id="delete_children_{{ $chil->id }}" title="Delete" class="delete_children"><i class="fas fa-trash fa-lg" aria-hidden="true"></i></a>
													</td>
													<td scope="col">{{ $chil->children }}</td>
													<td scope="col">{{ \Carbon\Carbon::parse($chil->dob)->diff(\Carbon\Carbon::now())->format('%y years') }}</td>
													<td scope="col">{{ $chil->belongtogender->gender }}</td>
													<td scope="col">{{ $chil->belongtoeducationlevel->education_level }}</td>
													<td scope="col">{{ $chil->belongtohealthstatus->health_status }}</td>
													<td scope="col">{{ ($chil->tax_exemption != 0)? 'Ya' : 'Tidak' }}</td>
													<td scope="col">{{ !isset($chil->tax_exemption_percentage_id) ? '' : $chil->belongtotaxexemptionpercentage->tax_exemption_percentage }}</td>
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

					<hr>
					<div class="row justify-content-center">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-header"><h2 class="card-title">Personal Waktu Kecemasan (Emergency Contact Person)</h2></div>
								<div class="card-body text-center table-responsive">

									<div class="col">
										<h4 class="card-title">Senarai Orang Yang Dihubungi Sewaktu Kecemasan</h4>
<?php
$eme = \App\Model\StaffEmergencyPerson::where('staff_id', $staff->id)->orderBy('id')->get();
?>
@if($eme->count() > 0 )
										<table class="table table-hover">
											<thead>
												<tr>
													<th scope="col">#</th>
													<th scope="col">Nama</th>
													<th scope="col">Hubungan</th>
													<th scope="col">Alamat</th>
													<th scope="col">&nbsp;</th>
												</tr>
											</thead>
											<tbody>
@foreach($eme as $emer)
												<tr>
													<td scope="col">
														<a href="{!! route('staffEmergencyPerson.edit', $emer->id) !!}" title="Edit"><i class="fas fa-pen-square fa-lg" aria-hidden="true"></i></a>

														<a href="{!! route('staffEmergencyPerson.destroy', $emer->id) !!}" data-id="{!! $emer->id !!}" data-token="{{ csrf_token() }}" id="delete_emergencyperson_<?=$emer->id ?>" title="Delete" class="delete_emergencyperson"><i class="fas fa-trash fa-lg" aria-hidden="true"></i></a>
													</td>
													<td scope="col">{{ $emer->contact_person }}</td>
													<td scope="col">{{ $emer->relationship }}</td>
													<td scope="col">{{ $emer->address }}</td>
													<td scope="col">
														<table>
															<thead>
																<tr>
																	<th scope="col">#</th>
																	<th scope="col">Telefon</th>
																</tr>
															</thead>
															<tbody>
<?php
$ph = \App\Model\StaffEmergencyPersonPhone::where('emergency_person_id', $emer->id)->orderBy('id')->get();
?>
@foreach ($ph as $phe)
																<tr>
																	<td scope="col">
																		<a href="{!! route('staffEmergencyPersonPhone.edit', $phe->id) !!}" title="Edit"><i class="fas fa-pen-square fa-lg" aria-hidden="true"></i></a>
																		
																		@if($ph->count() > 1)
																		<a href="{!! route('staffEmergencyPersonPhone.destroy', $phe->id) !!}" data-id="{!! $phe->id !!}" data-token="{{ csrf_token() }}" id="delete_emergencypersonphone_<?=$phe->id ?>" title="Delete" class="delete_emergencypersonphone"><i class="fas fa-trash fa-lg" aria-hidden="true"></i></a>
@else
@endif
																	</td>
																	<td scope="col">{{ $phe->phone }}</td>
																</tr>
@endforeach
															</tbody>
														</table>
													</td>
												</tr>
@endforeach
											</tbody>
										</table>
@else
										<p class="card-text text-justify text-lead">Sorry, no record for your emergency contact person. Please fill this form by clicking "Add Emergency Contact Person"</p>
@endif
									</div>
									<hr>
									<p>&nbsp;</p>

								</div>
								<div class="card-footer text-muted">
									<p class="card-text text-center"><a href="{{ route('staffEmergencyPerson.create') }}" class="btn btn-primary">Add Emergency Contact Person</a></p>
								</div>
							</div>
						</div>
					</div>
					
					<hr>
					<div class="row justify-content-center">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-header">
									<h2 class="card-title">Pengajian</h2>
								</div>
								<div class="card-body text-center table-responsive">

									<div class="col">
										<h4 class="card-title">Rekod Pengajian</h4>
<?php
$sib = \App\Model\StaffEducation::where('staff_id', $staff->id)->orderBy('from')->get();
?>
@if($sib->count() > 0 )
										<table class="table table-hover">
											<thead>
												<tr>
													<th scope="col">#</th>
													<th scope="col">Institusi</th>
													<th scope="col">Dari</th>
													<th scope="col">Hingga</th>
													<th scope="col">Kelulusan Tertinggi</th>
												</tr>
											</thead>
											<tbody>
@foreach($sib as $sibd)
												<tr>
													<td scope="col">
														<a href="{!! route('staffEducation.edit', $sibd->id) !!}" title="Edit"><i class="fas fa-pen-square fa-lg" aria-hidden="true"></i></a>

														<a href="{!! route('staffEducation.destroy', $sibd->id) !!}" data-id="{!! $sibd->id !!}" data-token="{{ csrf_token() }}" id="delete_staffEducation_<?=$sibd->id ?>" title="Delete" class="delete_staffEducation"><i class="fas fa-trash fa-lg" aria-hidden="true"></i></a>
													</td>
													<td scope="col">{{ $sibd->institution }}</td>
													<td scope="col">{{ my($sibd->from) }}</td>
													<td scope="col">{{ my($sibd->to) }}</td>
													<td scope="col">{{ $sibd->qualification }}</td>
												</tr>
@endforeach
											</tbody>
										</table>
@else
										<p class="card-text text-justify">Sorry, no record for your educations. Please fill this form by clicking "Add Educations"</p>
@endif
								</div>
								<div class="card-footer text-muted">
									<p class="card-text text-center"><a href="{{ route('staffEducation.create') }}" class="btn btn-primary">Add Educations</a></p>
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
// sweetalert2 delete emergency person

$(document).on('click', '.delete_emergencyperson', function(e){
	var emergencypersonID = $(this).data('id');
	SwalDeleteemergencyperson(emergencypersonID);
	e.preventDefault();
});

function SwalDeleteemergencyperson(emergencypersonID){
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
					url: '{{ url('staffEmergencyPerson') }}' + '/' + emergencypersonID,
					type: 'DELETE',
					data:	{
								id: emergencypersonID,
								_token : $('meta[name=csrf-token]').attr('content')
							},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status);
					$('#delete_emergencyperson_' + emergencypersonID).parent().parent().remove();
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
// sweetalert2 delete emergency person phone

$(document).on('click', '.delete_emergencypersonphone', function(e){
	var emergencypersonphoneID = $(this).data('id');
	SwalDeleteemergencypersonphone(emergencypersonphoneID);
	e.preventDefault();
});

function SwalDeleteemergencypersonphone(emergencypersonphoneID){
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
					url: '{{ url('staffEmergencyPersonPhone') }}' + '/' + emergencypersonphoneID,
					type: 'DELETE',
					data:	{
								id: emergencypersonphoneID,
								_token : $('meta[name=csrf-token]').attr('content')
							},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status);
					$('#delete_emergencypersonphone_' + emergencypersonphoneID).parent().parent().remove();
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
// sweetalert2 delete staff education

$(document).on('click', '.delete_staffEducation', function(e){
	var staffEducationID = $(this).data('id');
	SwalDeletestaffEducation(staffEducationID);
	e.preventDefault();
});

function SwalDeletestaffEducation(staffEducationID){
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
					url: '{{ url('staffEducation') }}' + '/' + staffEducationID,
					type: 'DELETE',
					data:	{
								id: staffEducationID,
								_token : $('meta[name=csrf-token]').attr('content')
							},
					dataType: 'json'
				})
				.done(function(response){
					swal('Deleted!', response.message, response.status);
					$('#delete_staffEducation_' + staffEducationID).parent().parent().remove();
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

@endsection

