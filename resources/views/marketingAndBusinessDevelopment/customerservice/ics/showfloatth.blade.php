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
					margin: 10mm auto;
		}
		div.page {
					page-break-after: always;
		}
		.responsive {
			max-width: 100%;
			height: auto;
		}
		table {
			font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
			font-size: 12px;
			border-collapse: collapse;
		}

		table td, table th {
			border: 1px solid #ddd;
			padding: 2px;
			height: 10px;
		}

		table tr:nth-child(even){background-color: #f2f2f2;}

		table tr:hover {background-color: #ddd;}

		table th {
			padding-top: 3px;
			padding-bottom: 3px;
			text-align: left;
			/*background-color: #4CAF50;*/
			background-color: #A9A9A9;
			color: white;
		}
	</style>

</head>
	<body>
	<h1>FLOAT TH</h1>
	<center>
		<table width="100%" cellspacing="1" cellpadding="1" border="0">
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
<?php $count = 0 ?>
@if($serviceReport->hasmanyjob()->get()->count() > 0)
@foreach($serviceReport->hasmanyjob()->get() as $srj5)
				<tr>
					<th align="left">Date : </th>
					<td colspan="14" align="left">{{ Carbon::parse($srj5->date)->format('D, j F Y') }}</td>
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
					<th align="left">Food :</th>
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
					<th align="left">Labour :</th>
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
					<th align="left">Overtime :</th>
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
					<th align="left">Accommodation :</th>
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
					<th align="left">Travel :</th>
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
					<th align="left">Travel Hour : </th>
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
					<th align="left">Total :</th>
					<td align="center" colspan="11"></td>
					<th align="center">RM</th>
					<th align="right">{{ number_format($total, 2) }}</th>
				</tr>
				<tr>
					<td colspan="14">&nbsp;</td>
				</tr>
@endforeach
				<tr>
					<th align="left">Total FLOAT TH :</th>
					<td align="center" colspan="11"></td>
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
					<th align="center" colspan="14">Logistic</th>
				</tr>
@foreach( $serviceReport->hasmanylogistic()->get() as $srl )
<?php $countl += $srl->charge ?>
				<tr>
					<th>{{ $srl->belongtovehicle->vehicle }}</th>
					<td align="center">{{ $srl->description }}</td>
					<td align="center" colspan="10"></td>
					<td align="center">RM</td>
					<td align="right">{{ $srl->charge }}</td>
				</tr>
@endforeach
				<tr>
					<td colspan="14">&nbsp;</td>
				</tr>
				<tr>
					<th align="left">Total Logistic :</th>
					<td align="center" colspan="11"></td>
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
					<th align="center" colspan="14">Additional Charges</th>
				</tr>
@foreach( $serviceReport->hasmanyadditionalcharge()->get() as $srac )
<?php $countac += $srac->value ?>
				<tr>
					<th align="left">{{ $srac->belongtoamount->amount }}</th>
					<td align="center">{{ $srac->description }}</td>
					<td align="center" colspan="10">&nbsp;</td>
					<td align="center">RM</td>
					<td align="right">{{ $srac->value }}</td>
				</tr>
@endforeach
				<tr>
					<td colspan="14">&nbsp;</td>
				</tr>
				<tr>
					<th align="left">Total Additional Charges :</th>
					<td align="center" colspan="11"></td>
					<th align="center">RM</th>
					<th align="right">{{ number_format($countac, 2) }}</th>
				</tr>
				<tr>
					<td colspan="14">&nbsp;</td>
				</tr>
@endif
<?php $countdis = 0 ?>
@if( !is_null($serviceReport->hasonediscount) )
<?php
// got 2 type of value
// 1. discount value
// 2. percentage value
// get all total

$call = $count + $countl + $countac;
if($serviceReport->hasonediscount->discount_id == 1) {		// 1 = percentage
	$countdis = ($serviceReport->hasonediscount->value * $call) / 100;
} elseif ($serviceReport->hasonediscount->discount_id == 2) {		// 2 = discount value
	$countdis = $serviceReport->hasonediscount->value;
}
?>
				<tr>
					<th colspan="14">Discount</th>
				</tr>
				<tr>
					<th align="left">{!! $serviceReport->hasonediscount->belongtodiscount->discount_type !!}</th>
					<td align="center">
						{!! ($serviceReport->hasonediscount->discount_id == 2)?'RM':NULL !!}
						{!! $serviceReport->hasonediscount->value !!}
						{!! ($serviceReport->hasonediscount->discount_id == 1)?'%':NULL !!}
					</td>
					<td colspan="10">&nbsp;</td>
					<th >RM</th>
					<th align="right">{!! number_format($countdis, 2) !!}</th>
				</tr>

@endif
				<tr>
					<th align="left">Grand Total</th>
					<td colspan="11">&nbsp;</td>
					<th>RM</th>
					<th align="right">{{ number_format((($count + $countl + $countac) - $countdis), 2) }}</th>
				</tr>
			</tbody>
		</table>
	</center>

	</body>
</html>