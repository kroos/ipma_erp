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
					size 21cm 29.7cm;
					/*margin: 3mm 5mm 3mm 5mm;*/
					margin: 15mm auto;
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
<?php
// im looking for a time period travel for 1 whole day only
$time_start1 = $srj1->hasmanysrjobdetail()->where('return', 0)->first()->time_start;
$time_end1 = $srj1->hasmanysrjobdetail()->where('return', 0)->first()->time_end;

$time_start2 = $srj1->hasmanysrjobdetail()->where('return', 1)->first()->time_start;
$time_end2 = $srj1->hasmanysrjobdetail()->where('return', 1)->first()->time_end;

$ms1 = $srj1->hasmanysrjobdetail()->where('return', 0)->first()->meter_start;
$me1 = $srj1->hasmanysrjobdetail()->where('return', 0)->first()->meter_end;

$ms2 = $srj1->hasmanysrjobdetail()->where('return', 1)->first()->meter_start;
$me2 = $srj1->hasmanysrjobdetail()->where('return', 1)->first()->meter_end;

if( is_null( $ms1 ) ) {
	$ms1 = 0;
}
if( is_null( $me1 ) ) {
	$me1 = 0;
}
if( is_null( $ms2 ) ) {
	$ms2 = 0;
}
if( is_null( $me2 ) ) {
	$me2 = 0;
}

if( is_null($time_start1) ) {
	$time_start1 = Carbon::now();
} 
if ( is_null($time_end1) ) {
	$time_end1 = Carbon::now();
}
if ( is_null($time_start2) ) {
	$time_start2 = Carbon::now();
}
if ( is_null($time_end2) ) {
	$time_end2 = Carbon::now();
}

// echo $time_start1.' time start1 '.$time_end1.' time end1<br />';
// echo $time_start2.' time start2 '.$time_end2.' time end2<br />';

$ts1 = CarbonPeriod::create($time_start1, '1 minutes', $time_end1);
$ts2 = CarbonPeriod::create($time_start2, '1 minutes', $time_end2);
// echo $ts1->count().' time period 1<br />';
// echo $ts2->count().' time period 2<br />';

$per = $ts1->count() + $ts2->count() - 2;
// echo $per.' minutes<br />';
$hours1 = floor($per / 60).' hours '.($per -   floor($per / 60) * 60).' minutes';
// echo $hours1.' <br />';

// time working
$wts = $srj1->working_time_start;
$wte = $srj1->working_time_end;
if ( is_null($wts) ) {
	$wts = Carbon::now();
}
if ( is_null($wte) ) {
	$wte = Carbon::now();
}
$wperm = CarbonPeriod::create($wts, '1 minutes', $wte)->count() - 1;
$hours2 = floor($wperm / 60).' hours '.($wperm -   floor($wperm / 60) * 60).' minutes';

$th = $per + $wperm;
$thours = floor($th / 60).' hours '.($th -   floor($th / 60) * 60).' minutes';
?>
										<tr>
											<td width="20%">{!! Carbon::parse($srj1->date)->format('j M Y') !!}</td>
											<td width="20%">{!! $srj1->labour !!}</td>
											<td width="20%">{{ $hours1 }}</td>
											<td width="20%">{{ $hours2 }}</td>
											<td width="20%">{{ $thours }}</td>
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
					</tbody>
				</table>
			</center>

<p style="page-break-before: always">
	<h1>ON-SITE SERVICE FEEDBACK</h1>
		<center>
			<table width="90%" border="1" cellspacing="1" cellpadding="1">
				<tbody>
					<tr>
						<td colspan="3" width="10%">Date</td>
						<td width="10%">Trip</td>
						<td width="10%">From</td>
						<td width="10%">To</td>
						<td width="10%">Meter Reading Start</td>
						<td width="10%">Meter Reading End</td>
						<td colspan="2" width="20%">Travel Time</td>
						<td colspan="2" width="20%">Working Time</td>
					</tr>
						
<?php $r = 1 ?>
@if( $serviceReport->hasmanyjob()->get()->count() > 0 )
@foreach( $serviceReport->hasmanyjob()->get() as $srj2 )
@if( $srj2->hasmanysrjobdetail()->get()->count() >0 )
@foreach( $srj2->hasmanysrjobdetail()->where('return', 0)->get() as $srjd1 )
					<tr>
						<td rowspan="2" colspan="3" width="10%">{!! Carbon::parse($srjd1->belongtoservicereportjob->date)->format('D, j M Y') !!}</td>
						<td width="10%">{!! $r++ !!}</td>
						<td width="10%">{{ $srjd1->destination_start }}</td>
						<td width="10%">{{ $srjd1->destination_end }}</td>
						<td width="10%">{{ $srjd1->meter_start }}</td>
						<td width="10%">{{ $srjd1->meter_end }}</td>
						<td width="10%">{{ Carbon::parse($srjd1->time_start)->format('h:i a') }}</td>
						<td width="10%">{{ Carbon::parse($srjd1->time_end)->format('h:i a') }}</td>
						<td rowspan="2" width="10%">{{ Carbon::parse($srjd1->belongtoservicereportjob->working_time_start)->format('h:i a') }}</td>
						<td rowspan="2" width="10%">{{ Carbon::parse($srjd1->belongtoservicereportjob->working_time_end)->format('h:i a') }}</td>
					</tr>
@endforeach
@foreach( $srj2->hasmanysrjobdetail()->where('return', 1)->get() as $srjd2 )
					<tr>
						<td width="10%">{!! __('Back') !!}</td>
						<td width="10%">{{ $srjd2->destination_start }}</td>
						<td width="10%">{{ $srjd2->destination_end }}</td>
						<td width="10%">{{ $srjd2->meter_start }}</td>
						<td width="10%">{{ $srjd2->meter_end }}</td>
						<td width="10%">{{ Carbon::parse($srjd2->time_start)->format('h:i a') }}</td>
						<td width="10%">{{ Carbon::parse($srjd2->time_end)->format('h:i a') }}</td>
					</tr>
@endforeach
@endif
@endforeach
@else

@endif
					</tbody>
				</table>
			</center>
<p style="page-break-before: always">
	<h1>FLOAT TH</h1>
	<center>
		<table width="90%" cellspacing="1" cellpadding="1" border="0">
			<tbody>
				<tr>
					<th colspan="14" align="center">
						Service Report NO :
@foreach($serviceReport->hasmanyserial()->get() as $srs1 )
						 					{{ $srs1->serial }}, 
@endforeach
					</th>
				</tr>
				<tr>
					<th colspan="14" align="center">
						Customer : {!! (!is_null($serviceReport->belongtocustomer()))?$serviceReport->belongtocustomer->customer:NULL !!}
					</th>
				</tr>
				<tr>
					<td colspan="14">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="14">&nbsp;</td>
				</tr>
@if($serviceReport->hasmanyjob()->get()->count() > 0)
<?php $count = 0 ?>
@foreach($serviceReport->hasmanyjob()->get() as $srj5)
				<tr>
					<th>Date : </th>
					<th colspan="14" align="left">{{ Carbon::parse($srj5->date)->format('D, j F Y') }}</th>
				</tr>
				<tr>
					<td colspan="14">&nbsp;</td>
				</tr>
				<tr>
<?php
$f1 = $srj5->food_rate * $srj5->labour;
$f2 = ($srj5->labour_leader + ($srj5->labour_non_leader * ($srj5->labour - 1))) / $srj5->working_type_value;
$f3 = ($f2 * $srj5->working_type_value) * $srj5->overtime_constant_1 * $srj5->overtime_constant_2 * $srj5->overtime_hour;
$f4 = $srj5->accommodation_rate * $srj5->accommodation;

foreach( $srj5->hasmanysrjobdetail()->where('return', 0)->get() as $srjd5 ) {
	// echo $srjd5->meter_start.' <br />';
	// echo $srjd5->meter_end.' <br />';
	$m1 = $srjd5->meter_end - $srjd5->meter_start;
	// echo $m1.' <br />';
}
foreach ( $srj5->hasmanysrjobdetail()->where('return', 1)->get() as $srjd6 ) {
	// echo $srjd6->meter_start.' <br />';
	// echo $srjd6->meter_end.' <br />';
	$m2 = $srjd6->meter_end - $srjd6->meter_start;
	// echo $m2.' <br />';
}

$f5 = ($m1 + $m2) * $srj5->travel_meter_rate;
$f6 = ( $f2 * $srj5->working_type_value ) * $srj5->travel_hour_constant * $srj5->travel_hour;

$total = $f1 + $f2 + $f3 + $f4 + $f5 + $f6;
$count += $total;
?>
					<th>Food :</th>
					<td align="center">RM</td>
					<td align="center">{{ $srj5->food_rate }}</td>
					<td align="center">X</td>
					<td align="center">{{ $srj5->labour }}</td>
					<td align="center" colspan="6"></td>
					<td align="center">=</td>
					<td align="center">RM</td>
					<td align="right">{{ number_format($f1, 2) }}</td>
				</tr>
				<tr>
					<th>Labour :</th>
					<td align="center">( RM</td>
					<td align="center">{{ $srj5->labour_leader }}</td>
					<td align="center">+</td>
					<td align="center">RM</td>
					<td align="center">{{ $srj5->labour_non_leader }}</td>
					<td align="center">X</td>
					<td align="center">{{ $srj5->labour - 1 }}</td>
					<td align="center">)</td>
					<td align="center">/</td>
					<td align="center">{{ $srj5->working_type_value }}</td>
					<td align="center">=</td>
					<td align="center">RM</td>
					<td align="right">{{ number_format($f2, 2) }}</td>
				</tr>
				<tr>
					<th>Overtime :</th>
					<td align="center">RM</td>
					<td align="center">{{ $f2 * $srj5->working_type_value }}</td>
					<td align="center">X</td>
					<td align="center">{{ $srj5->overtime_constant_1 }}</td>
					<td align="center">X</td>
					<td align="center">{{ $srj5->overtime_constant_2 }}</td>
					<td align="center">X</td>
					<td align="center">{{ $srj5->overtime_hour }}</td>
					<td align="center" colspan="2"></td>
					<td align="center">=</td>
					<td align="center">RM</td>
					<td align="right">{{ number_format($f3, 2) }}</td>
				</tr>
				<tr>
					<th>Accommodation :</th>
					<td align="center">RM</td>
					<td align="center">{{ $srj5->accommodation_rate }}</td>
					<td align="center">X</td>
					<td align="center">{{ $srj5->accommodation }}</td>
					<td align="center" colspan="6"></td>
					<td align="center">=</td>
					<td align="center">RM</td>
					<td align="right">{{ number_format($f4, 2) }}</td>
				</tr>
				<tr>
					<th>Travel :</th>
					<td align="center">{{ ($m1 + $m2) }}</td>
					<td align="center">KM</td>
					<td align="center">X</td>
					<td align="center">RM</td>
					<td align="center">{{ $srj5->travel_meter_rate }}</td>
					<td align="center" colspan="5"></td>
					<td align="center">=</td>
					<td align="center">RM</td>
					<td align="right">{{ number_format($f5, 2) }}</td>
				</tr>
				<tr>
					<th>Travel Hour : </th>
					<td align="center">RM</td>
					<td align="center">{{ $f2 * $srj5->working_type_value }}</td>
					<td align="center">X</td>
					<td align="center">{{ $srj5->travel_hour_constant }}</td>
					<td align="center">X</td>
					<td align="center">{{ $srj5->travel_hour }}</td>
					<td align="center">Hour</td>
					<td align="center" colspan="3"></td>
					<td align="center">=</td>
					<td align="center">RM</td>
					<td align="right">{{ number_format($f6, 2) }}</td>
				</tr>
				<tr>
					<th>Total :</th>
					<th align="center" colspan="11"></th>
					<th align="center">RM</th>
					<th align="right">{{ number_format($total, 2) }}</th>
				</tr>
				<tr>
					<td colspan="14">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="14">&nbsp;</td>
				</tr>
@endforeach
				<tr>
					<th>Total All :</th>
					<th align="center" colspan="11"></th>
					<th align="center">RM</th>
					<th align="right">{{ number_format($count, 2) }}</th>
				</tr>
@endif
				<tr>
					<td colspan="14">&nbsp;</td>
				</tr>
<?php $countl = 0 ?>
@if( $serviceReport->hasmanylogistic()->get()->count() > 0 )
				<tr>
					<th colspan="14" align="center">Logistic</th>
				</tr>
@foreach( $serviceReport->hasmanylogistic()->get() as $srl )
<?php $countl += $srl->charge ?>
				<tr>
					<th>{{ $srl->belongtovehicle->vehicle }}</th>
					<td align="center">{{ $srl->description }}</td>
					<td align="center" colspan="10"></td>
					<th align="center">RM</th>
					<th align="right">{{ $srl->charge }}</th>
				</tr>
@endforeach
				<tr>
					<td colspan="14">&nbsp;</td>
				</tr>
				<tr>
					<th>Total Logistic :</th>
					<th align="center" colspan="11"></th>
					<th align="center">RM</th>
					<th align="right">{{ number_format($countl, 2) }}</th>
				</tr>
				<tr>
					<td colspan="14">&nbsp;</td>
				</tr>
@endif
<?php $countac = 0; ?>
@if( $serviceReport->hasmanyadditionalcharge()->get()->count() > 0 )
				<tr>
					<th colspan="14" align="center">Additional Charges</th>
				</tr>
@foreach( $serviceReport->hasmanyadditionalcharge()->get() as $srac )
				<tr>
					<th>{{ $srac->belongtoamount->amount }}</th>
					<td align="center">{{ $srac->description }}</td>
					<td align="center" colspan="10">&nbsp;</td>
					<th align="center">RM</th>
					<th align="right">{{ $srac->value }}</th>
				</tr>
@endforeach
				<tr>
					<th>Total :</th>
					<th align="center" colspan="11"></th>
					<th align="center">RM</th>
					<th align="right">{{ number_format($countac, 2) }}</th>
				</tr>
@endif
			</tbody>
		</table>
	</center>
<p style="page-break-before: always">
	</body>
</html>