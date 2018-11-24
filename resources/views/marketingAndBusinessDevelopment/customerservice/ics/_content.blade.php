<?php
use \App\Model\ICSServiceReport;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

$now = Carbon::now();
$year = $now->copy()->startOfYear()->format('Y-m-d');

// echo $year.' year<br />';

$sre = ICSServiceReport::where([['date', '>=', $year], ['active', 1]])->get();
?>
<table class="table table-hover" style="font-size:12px" id="servicereport">
	<thead>
		<tr>
			<th>ID</th>
			<th>Date</th>
			<th>SR No</th>
			<th>Customer</th>
			<th>Attendees (Count)</th>
			<th>Complaints</th>
			<th>Date Spend</th>
			<th>Vehicle</th>
			<th>Proceed</th>
			<th>Approve By</th>
			<th>Remarks</th>
			<th>Invoice</th>
		</tr>
	</thead>
	<tbody>
@foreach($sre as $sr)
		<tr>
			<td>{!! $sr->id !!}</td>
			<td>{!! Carbon::parse($sr->date)->format('D, j F Y') !!}</td>
			<td>
<?php
// $sr->hasmanyserial()->get();
?>
@foreach( $sr->hasmanyserial()->get() as $srno )
				{!! $srno->serial !!}<br />
@endforeach
			</td>
			<td>{!! $sr->belongtocustomer->customer !!}</td>
			<td>
@foreach( $sr->hasmanyattendees()->get() as $sra )
				{!! $sra->belongtostaff->name !!}<br />
@endforeach
			</td>
			<td>
@foreach($sr->hasmanycomplaint()->get() as $src)
				{!! $src->complaint !!}
@endforeach
			</td>
			<td></td>
			<td>
@if( !is_null($sr->belongtovehicle) )
				{!! $sr->belongtovehicle->vehicle !!}
@endif
			</td>
			<td>
@if( !is_null($sr->belongtoproceed) )
				{!! $sr->belongtoproceed->proceed !!}
@endif
			</td>
			<td>
@if(!is_null($sr->belongtoapproval))
				{!! $sr->belongtoapproval->name !!}
@endif
			</td>
			<td>
@if(!is_null($sr->hasmanyjob()))
				{!! __('Incomplete') !!}
@endif
			</td>
			<td>
@if( !is_null( $sr->belongtoinvoice ))
				{!! $sr->belongtoinvoice->DocNo !!}
@else
				{!! __('No Invoice') !!}
@endif
			</td>
			<td></td>
		</tr>
@endforeach
	</tbody>
<!-- 	<tfoot>
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
	</tfoot> -->
</table>