<?php
use \App\Model\ICSServiceReport;

use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
?>
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
	<!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
	<style type="text/css">
		body {
			background-color: #FFF;
		}
		@page {
					size 21cm 29.7cm; margin: 3mm 5mm 3mm 5mm;
		}
		div.page {
					page-break-after: always;
		}
		.responsive {
			max-width: 100%;
			height: auto;
		}
	</style>

</head>
	<body>
		<center>
			<img src="{{ asset('images/sr_header.png') }}" alt="Service Report Header" class="responsive">			
		</center>

			<center>
				<table width="90%" border="1" cellspacing="1" cellpadding="1">
					<tbody>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td colspan="10" width="70%">
								<center><h1><u>Service Report</u></h1></center>
							</td>
							<td colspan="2" width="30%">
								<table width="100%" cellspacing="1" cellpadding="1">
									<tbody>
@if ($serviceReport->hasmanyserial()->get()->count() > 0)
@foreach($serviceReport->hasmanyserial()->get() as $srs)
										<tr>
											<td>No : </td>
											<td>{!! $srs->serial !!}</td>
										</tr>
@endforeach
@else
										<tr>
											<td>No : </td>
											<td></td>
										</tr>
@endif
										<tr>
											<td>Date : </td>
											<td>{{ Carbon::parse($serviceReport->date)->format('D, j M Y') }}</td>
										</tr>
										<tr>
											<td>Informed By : </td>
											<td>Mr. {{ $serviceReport->belongtoinformby->name }}</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="6" width="50%">
								<p>
									Customer : {!! (!is_null($serviceReport->belongtocustomer()))?$serviceReport->belongtocustomer->customer:NULL !!}
									<br />
									Attn : {!! (!is_null($serviceReport->belongtocustomer()))?$serviceReport->belongtocustomer->pc:NULL !!}
									<br />
									Telephone : {!! (!is_null($serviceReport->belongtocustomer()))?$serviceReport->belongtocustomer->phone:NULL !!}
								</p>
							</td>
							<td colspan="6" width="50%">
								<table width="100%" cellpadding="1" cellspacing="1" border="0">
									<tbody>
										<tr>
											<td colspan="3">
												<label for="n1"><input type="checkbox" name="" value="1" id="n1" {!! (!is_null($serviceReport->charge_id))?(($serviceReport->charge_id == 1)?'checked':NULL):NULL !!} disabled>&nbsp;Charge Parts</label>&nbsp;&nbsp;&nbsp;
												<label for="n2"><input type="checkbox" disabled="disabled" {!! (!is_null($serviceReport->charge_id))?(($serviceReport->charge_id == 2)?'checked':NULL):NULL !!} >&nbsp;Full Charge</label>
											</td>
										</tr>
										<tr>
											<td colspan="3">Service attended by : </td>
										</tr>
<?php $i = 1 ?>
@if($serviceReport->hasmanyattendees()->get()->count() > 0)
@foreach($serviceReport->hasmanyattendees()->get() as $sra)
										<tr>
											<td>{{ $i++ }}. </td>
											<td>{!! $sra->belongtostaff->hasmanylogin()->where('active', 1)->first()->username !!}</td>
											<td>{!! $sra->belongtostaff->name !!}</td>
										</tr>
@endforeach
@else
										<tr>
											<td>No Attendees Yet</td>
										</tr>
@endif
									</tbody>									
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="6" width="50%" valign="top">
								<p>Nature of Complaints : <br />
@if($serviceReport->hasmanycomplaint()->get()->count() > 0)
@foreach($serviceReport->hasmanycomplaint()->get() as $src1)
									{!! $src1->complaint !!}
@endforeach
@else
								No Complaints Have Been Recorded Yet
@endif
								</p>
								<p>Complaints By : <br />
@if($serviceReport->hasmanycomplaint()->get()->count() > 0)
@foreach($serviceReport->hasmanycomplaint()->get() as $src2)
									{!! $src2->complaint_by !!}
@endforeach
@else
@endif
								</p>
							</td>
							<td colspan="6" valign="top">
								<table width="100%" cellspacing="1" cellpadding="1">
									<tbody>
@if($serviceReport->hasmanymodel()->get()->count() > 0)
@foreach($serviceReport->hasmanymodel()->get() as $srm)
										<tr>
											<td>Model :</td>
											<td>{!! $srm->belongtomachinemodel->model !!}</td>
										</tr>
										<tr>
											<td>Test Run Machine :</td>
											<td>{!! $srm->test_run_machine !!}</td>
										</tr>
										<tr>
											<td>Serial No :</td>
											<td>{!! $srm->serial_no !!}</td>
										</tr>
										<tr>
											<td>Test Capacity :</td>
											<td>{!! $srm->test_capacity !!}</td>
										</tr>
										<tr>
											<td>Duration :</td>
											<td>{!! $srm->duration !!}</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
										</tr>
@endforeach
@else
										<tr>
											<td>Model :</td>
											<td></td>
										</tr>
										<tr>
											<td>Test Run Machine :</td>
											<td></td>
										</tr>
										<tr>
											<td>Serial No :</td>
											<td></td>
										</tr>
										<tr>
											<td>Test Capacity :</td>
											<td></td>
										</tr>
										<tr>
											<td>Duration :</td>
											<td></td>
										</tr>
@endif
									</tbody>
								</table>
							</td>
						</tr>
						<tr valign="top">
							<td colspan="12">
								<p>Job Performed :</p>
@if($serviceReport->hasmanyjob()->get()->count() > 0)
@foreach($serviceReport->hasmanyjob()->get() as $srj)
								<p>{!! Carbon::parse($srj->date)->format('D, j M Y') !!} - {!! $srj->job_perform !!}</p>
@endforeach
@else
@endif
							</td>
						</tr>
						<tr>
							<td colspan="6" width="50%" valign="top">
								<table width="100%" border="1" cellspacing="1" cellpadding="1">
									<tbody>
										<tr>
											<td colspan="3" width="30%">Parts & Accessories</td>
											<td colspan="1" width="10%">Quantity</td>
										</tr>
@if($serviceReport->hasmanypart()->get()->count() > 0)
@foreach($serviceReport->hasmanypart()->get() as $srp)
										<tr>
											<td colspan="3">{!! $srp->part_accessory !!}</td>
											<td colspan="1">{!! $srp->qty !!}</td>
										</tr>
@endforeach
@else
										<tr>
											<td colspan="3">&nbsp;</td>
											<td colspan="1">&nbsp;</td>
										</tr>
@endif
									</tbody>
								</table>
							</td>
							<td colspan="6" width="50%">
								<table width="100%" border="1" cellspacing="1" cellpadding="1">
									<tbody>
										<tr>
											<td colspan="5" align="center">Time Spent</td>
										</tr>
										<tr>
											<td width="20%">Date</td>
											<td width="20%">No. Of Labour</td>
											<td width="20%">Travel Time</td>
											<td width="20%">Working Time</td>
											<td width="20%">Total</td>
										</tr>
@if($serviceReport->hasmanyjob()->get()->count() > 0)
@foreach($serviceReport->hasmanyjob()->get() as $srj1)
										<tr>
											<td width="20%">{!! Carbon::parse($srj1->date)->format('D, j M Y') !!}</td>
											<td width="20%">{!! $srj1->labour !!}</td>
											<td width="20%"></td>
											<td width="20%"></td>
											<td width="20%"></td>
										</tr>
@endforeach
@else
										<tr>
											<td width="20%">&nbsp;</td>
											<td width="20%">&nbsp;</td>
											<td width="20%">&nbsp;</td>
											<td width="20%">&nbsp;</td>
											<td width="20%">&nbsp;</td>
										</tr>
@endif
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="12">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="12">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="3" width="10%">Date</td>
							<td width="10%">Trip</td>
							<td width="10%">From</td>
							<td width="10%">Meter Reading Start</td>
							<td width="10%">To</td>
							<td width="10%">Meter Reading End</td>
							<td colspan="2" width="20%">Travel Time</td>
							<td colspan="2" width="20%">Working Time</td>
						</tr>
@if()
@foreach()
						<tr>
							<td colspan="3" width="10%">Date</td>
							<td width="10%">Trip</td>
							<td width="10%">From</td>
							<td width="10%">Meter Reading Start</td>
							<td width="10%">To</td>
							<td width="10%">Meter Reading End</td>
							<td colspan="2" width="20%">Travel Time</td>
							<td colspan="2" width="20%">Working Time</td>
						</tr>
@endforeach
@else
@endif
					</tbody>
				</table>
			</center>

	</body>
</html>