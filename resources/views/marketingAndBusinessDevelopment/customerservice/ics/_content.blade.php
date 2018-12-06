<?php
use \App\Model\ICSServiceReport;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

$now = Carbon::now();
$year = $now->copy()->startOfYear()->format('Y-m-d');

// echo $year.' year<br />';

$sre = ICSServiceReport::where([['date', '>=', $year], ['active', 1], ['approved_by', '<>', NULL]])->get();
$srp = ICSServiceReport::where([['date', '>=', $year], ['active', 1], ['approved_by',  NULL]])->get();

$sr0 = ICSServiceReport::where([['date', '>=', $year], ['active', 1]])->get();



?>
<h5>Approved Service Report</h5>
<table class="table table-hover" style="font-size:12px" id="servicereport1">
	<thead>
		<tr>
			<th>ID</th>
			<th>Date</th>
			<th>Informed By</th>
			<th>SR No</th>
			<th>Customer</th>
			<th>Attendees</th>
			<th>Complaints</th>
			<th>Date Completed</th>
			<th>Vehicle</th>
			<th>Proceed</th>
			<th>Approve By</th>
			<th>Remarks</th>
			<th>Invoice</th>
			<th>&nbsp</th>
		</tr>
	</thead>
	<tbody>
@foreach($sre as $sr)
		<tr>
			<td>{!! $sr->id !!}</td>
			<td>{!! Carbon::parse($sr->date)->format('D, j M Y') !!}</td>
			<td>{!! $sr->belongtoinformby->name !!}</td>
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
			<td>
@if( !is_null($sr->hasmanyjob) )
				{!! Carbon::parse($sr->hasmanyjob()->get()->max('date'))->format('D, j M Y') !!}
@endif
			</td>
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
				{!! $sr->remarks !!}
			</td>
			<td>
@if( !is_null( $sr->belongtoinvoice ))
				{!! $sr->belongtoinvoice->DocNo !!}
@else
				{!! __('No Invoice') !!}
@endif
			</td>
			<td>
				<a href="{!! route('serviceReport.edit', $sr->id) !!}" title="Update"><i class="far fa-edit"></i></a>
				<span class="text-danger"><i class="far fa-trash-alt"></i></span>
			</td>
		</tr>
@endforeach
	</tbody>
</table>
<p>&nbsp;</p>

<h5>Unapproved Service Report</h5>
<table class="table table-hover" style="font-size:12px" id="servicereport2">
	<thead>
		<tr>
			<th>ID</th>
			<th>Date</th>
			<th>Informed By</th>
			<th>SR No</th>
			<th>Customer</th>
			<th>Attendees</th>
			<th>Complaints</th>
			<th>Date Completed</th>
			<th>Vehicle</th>
			<th>Proceed</th>
			<th>Approve By</th>
			<th>Remarks</th>
			<th>Invoice</th>
			<th>&nbsp</th>
		</tr>
	</thead>
	<tbody>
@foreach($srp as $sr)
		<tr>
			<td>{!! $sr->id !!}</td>
			<td>{!! Carbon::parse($sr->date)->format('D, j M Y') !!}</td>
			<td>{!! $sr->belongtoinformby->name !!}</td>
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
			<td>
@if( !is_null($sr->hasmanyjob) )
				{!! Carbon::parse($sr->hasmanyjob()->get()->max('date'))->format('D, j M Y') !!}
@endif
			</td>
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
				{!! $sr->remarks !!}
			</td>
			<td>
@if( !is_null( $sr->belongtoinvoice ))
				{!! $sr->belongtoinvoice->DocNo !!}
@else
				{!! __('No Invoice') !!}
@endif
			</td>
			<td>
				<a href="{!! route('serviceReport.edit', $sr->id) !!}" title="Update"><i class="far fa-edit"></i></a>
				<span class="text-danger"><i class="far fa-trash-alt"></i></span>
			</td>
		</tr>
@endforeach
	</tbody>
</table>
<p>&nbsp;</p>

<h5>Keep In Vew Service Report</h5>
<table class="table table-hover" style="font-size:12px" id="servicereport3">
	<thead>
		<tr>
			<th>ID</th>
			<th>Date</th>
			<th>Informed By</th>
			<th>SR No</th>
			<th>Customer</th>
			<th>Attendees</th>
			<th>Complaints</th>
			<th>Date Completed</th>
			<th>Vehicle</th>
			<th>Proceed</th>
			<th>Approve By</th>
			<th>Remarks</th>
			<th>Invoice</th>
			<th>&nbsp</th>
		</tr>
	</thead>
	<tbody>
@foreach($srp as $sr)

@if( $sr->hasmanyserial()->whereNull('serial')->first() )
		<tr>
			<td>{!! $sr->id !!}</td>
			<td>{!! Carbon::parse($sr->date)->format('D, j M Y') !!}</td>
			<td>{!! $sr->belongtoinformby->name !!}</td>
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
			<td>
@if( !is_null($sr->hasmanyjob) )
				{!! Carbon::parse($sr->hasmanyjob()->get()->max('date'))->format('D, j M Y') !!}
@endif
			</td>
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
				{!! $sr->remarks !!}
			</td>
			<td>
@if( !is_null( $sr->belongtoinvoice ))
				{!! $sr->belongtoinvoice->DocNo !!}
@else
				{!! __('No Invoice') !!}
@endif
			</td>
			<td>
				<a href="{!! route('serviceReport.edit', $sr->id) !!}" title="Update"><i class="far fa-edit"></i></a>
				<span class="text-danger"><i class="far fa-trash-alt"></i></span>
			</td>
		</tr>
@endif
@endforeach
	</tbody>
</table>
<p>&nbsp;</p>

