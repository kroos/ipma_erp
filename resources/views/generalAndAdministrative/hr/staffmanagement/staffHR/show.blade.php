@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header"><h1>Human Resource Department</h1></div>
	<div class="card-body">
		@include('layouts.info')
		@include('layouts.errorform')

		<ul class="nav nav-tabs">
@foreach( App\Model\Division::find(1)->hasmanydepartment()->whereNotIn('id', [22, 23, 24])->get() as $key)
			<li class="nav-item">
				<a class="nav-link {{ ($key->id == 3)? 'active' : 'disabled' }}" href="{{ route("$key->route.index") }}">{{ $key->department }}</a>
			</li>
@endforeach
		</ul>

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link " href="{{ route('hrSettings.index') }}">Settings</a>
			</li>
			<li class="nav-item">
				<a class="nav-link active" href="{{ route('staffManagement.index') }}">Staff Management</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('leaveEditing.index') }}">Leave</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('tcms.index') }}">TCMS</a>
			</li>
		</ul>

		<div class="card">
			<div class="card-header">Staff Management</div>
			<div class="card-body">









<div class="card">
	<div class="card-header">
		<h1>{{ $staffHR->name }} Profile</h1>
	</div>
	<div class="card-body">









			<div class="card text-center">
				<div class="col-2 offset-5">
					<img class="card-img-top rounded" src="{{ asset('storage/'.$staffHR->image) }}" alt="{{ $staffHR->name }} Image">
				</div>
				<h2 class="card-title card-title">{{ $staffHR->name }}</h2>
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
											<td scope="col">{{ empty($staffHR->belongtostatus->status)? 'Not Set' : $staffHR->belongtostatus->status }}, {{ empty($staffHR->belongtostatus->code)? '' : $staffHR->belongtostatus->code }}</td>
										</tr>
										<tr>
											<td scope="col">ID Pekerja :</td>
											<td scope="col">{{ empty($staffHR->hasmanylogin()->where('active', 1)->first()->username)?'Not Set':$staffHR->hasmanylogin()->where('active', 1)->first()->username }}</td>
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
											<td scope="col">{{ empty($staffHR->location_id)?'Not Set':$staffHR->belongtolocation->location }}</td>
										</tr>
										<tr>
											<td scope="col">Email :</td>
											<td scope="col">{{ $staffHR->email }}</td>
										</tr>
										<tr>
											<td scope="col">Kad Pengenalan :</td>
											<td scope="col">{{ $staffHR->id_card_passport }}</td>
										</tr>
										<tr>
											<td scope="col">Agama :</td>
											<td scope="col">{{ empty($staffHR->belongtoreligion->religion)? 'Not Set' : $staffHR->belongtoreligion->religion }}</td>
										</tr>
										<tr>
											<td scope="col">Lesen Memandu :</td>
											<td scope="col">
												<table>
													<tbody>
<?php
$dr = \App\Model\StaffDrivingLicense::where('staff_id', $staffHR->id)->orderBy('id')->get();
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
											<td>{{ empty($staffHR->belongtogender->gender)? 'Not Set' : $staffHR->belongtogender->gender }}</td>
										</tr>
										<tr>
											<td>Bangsa :</td>
											<td>{{ empty($staffHR->belongtorace->race)? 'Not Set' : $staffHR->belongtorace->race }}</td>
										</tr>
										<tr>
											<td>Alamat :</td>
											<td>{{ empty($staffHR->address) ? 'Not Set' : $staffHR->address }}</td>
										</tr>
										<tr>
											<td>Tempat Lahir :</td>
											<td>{{ $staffHR->place_of_birth }}</td>
										</tr>
										<tr>
											<td>Warganegara :</td>
											<td>{{ empty($staffHR->belongtocountry->country)? 'Not Set' : $staffHR->belongtocountry->country }}</td>
										</tr>
										<tr>
											<td>Taraf Perkahwinan :</td>
											<td>{{ empty($staffHR->belongtomaritalstatus->marital_status)? 'Not Set' : $staffHR->belongtomaritalstatus->marital_status }}</td>
										</tr>
										<tr>
											<td>Telefon Bimbit :</td>
											<td>{{ $staffHR->mobile }}</td>
										</tr>
										<tr>
											<td>Talian Tetap :</td>
											<td>{{ $staffHR->phone }}</td>
										</tr>
										<tr>
											<td>Tarikh Lahir :</td>
											<td>{{ my($staffHR->dob) }}</td>
										</tr>
										<tr>
											<td>Umur :</td>
											<td>{{ \Carbon\Carbon::parse($staffHR->dob)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days') }}</td>
										</tr>
										<tr>
											<td>Akaun CIMB :</td>
											<td>{{ $staffHR->cimb_account }}</td>
										</tr>
										<tr>
											<td>Akaun KWSP :</td>
											<td>{{ $staffHR->epf_no }}</td>
										</tr>
										<tr>
											<td>Nombor Cukai Pendapatan :</td>
											<td>{{ $staffHR->income_tax_no }}</td>
										</tr>
									</tbody>
								</table>

								</div>
								<div class="card-footer text-muted">
									<a href="{{ route('staffHR.edit', $staffHR->id) }}" class="btn btn-primary">Edit Profile</a>
								</div>
							</div>
						</div>
						<div class="col-lg-7">
							<div class="card">
								<div class="card-header"><h2 class="card-title">Keluarga (Family And Siblings)</h2></div>
								<div class="card-body text-center table-responsive">
<?php
$sib = \App\Model\StaffSibling::where('staff_id', $staffHR->id)->orderBy('dob')->get();
?>
									<div class="col">
										<h4 class="card-title">Saudara Kandung</h4>
@if($sib->count() > 0 )
										<table class="table table-hover">
											<thead>
												<tr>
													<th scope="col">Nama</th>
													<th scope="col">Telefon</th>
													<th scope="col">Umur</th>
													<th scope="col">Pekerjaan</th>
												</tr>
											</thead>
											<tbody>
@foreach($sib as $sibl)
												<tr>
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
									</div>
<hr>
									<p>&nbsp;</p>
@if($staffHR->marital_status_id != 1)
<?php
$spo = \App\Model\StaffSpouse::where('staff_id', $staffHR->id)->orderBy('dob')->get();
?>
									<div class="col">
										<h4 class="card-title">Pasangan</h4>
@if($spo->count() > 0 )
										<table class="table table-hover">
											<thead>
												<tr>
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
									</div>
									<hr>
									<p>&nbsp;</p>
<?php
$chi = \App\Model\StaffChildren::where('staff_id', $staffHR->id)->orderBy('dob')->get();
?>
									<div class="col">
										<h4 class="card-title">Anak</h4>
@if($chi->count() > 0 )
										<table class="table table-hover">
											<thead>
												<tr>
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
									</div>
									<hr>
									<p>&nbsp;</p>
@endif
								</div>
								<div class="card-footer text-muted">
									<!-- <a href="{{ route('staff.edit', $staffHR->id) }}" class="btn btn-primary">Edit Family</a> -->
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
$eme = \App\Model\StaffEmergencyPerson::where('staff_id', $staffHR->id)->orderBy('id')->get();
?>
@if($eme->count() > 0 )
										<table class="table table-hover">
											<thead>
												<tr>
													<th scope="col">Nama</th>
													<th scope="col">Hubungan</th>
													<th scope="col">Alamat</th>
													<th scope="col">&nbsp;</th>
												</tr>
											</thead>
											<tbody>
@foreach($eme as $emer)
												<tr>
													<td scope="col">{{ $emer->contact_person }}</td>
													<td scope="col">{{ $emer->relationship }}</td>
													<td scope="col">{{ $emer->address }}</td>
													<td scope="col">
														<table>
															<thead>
																<tr>
																	<th scope="col">Telefon</th>
																</tr>
															</thead>
															<tbody>
<?php
$ph = \App\Model\StaffEmergencyPersonPhone::where('emergency_person_id', $emer->id)->orderBy('id')->get();
?>
@foreach ($ph as $phe)
																<tr>
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
$sib = \App\Model\StaffEducation::where('staff_id', $staffHR->id)->orderBy('from')->get();
?>
@if($sib->count() > 0 )
										<table class="table table-hover">
											<thead>
												<tr>
													<th scope="col">Institusi</th>
													<th scope="col">Dari</th>
													<th scope="col">Hingga</th>
													<th scope="col">Kelulusan Tertinggi</th>
												</tr>
											</thead>
											<tbody>
@foreach($sib as $sibd)
												<tr>
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
									</div>
								</div>
							</div>
						</div>
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
$(document).on('keyup', '#hol', function () {
	tch(this);
});

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

