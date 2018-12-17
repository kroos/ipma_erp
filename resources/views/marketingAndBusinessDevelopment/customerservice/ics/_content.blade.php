<?php
ini_set('max_execution_time', 180);
use \App\Model\ICSServiceReport;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

$now = Carbon::now();
$bor1 = Carbon::create($now->year, $now->month, $now->day, 0, 0, 0);
$bor2 = $now->copy()->startOfYear()->format('Y-m-d');

$bmonth = $now->month;
// echo $bmonth.' month now <br />';
// echo $bor1.' now <br />';
// echo $bor1->copy()->subMonths(3)->startOfMonth().' from start of last month<br />';
$bor3 = $bor1->copy()->subMonths(3)->startOfMonth()->format('Y-m-d');

// echo $year.' year<br />';
if ( $bmonth != 1 ) {
	$sre = ICSServiceReport::where([['date', '>=', $bor2], ['active', 1], ['approved_by', '<>', NULL]])->get();
	$srp = ICSServiceReport::where([['date', '>=', $bor2], ['active', 1], ['approved_by',  NULL]])->get();
	$sr0 = ICSServiceReport::where([['date', '>=', $bor2], ['active', 1]])->get();
} else {
	// if its in january, check the create date from early last month : 1 December, so can capture the sr.
	$sre = ICSServiceReport::where([['date', '>=', $bor3], ['active', 1], ['approved_by', '<>', NULL]])->get();
	$srp = ICSServiceReport::where([['date', '>=', $bor3], ['active', 1], ['approved_by',  NULL]])->get();
	$sr0 = ICSServiceReport::where([['date', '>=', $bor3], ['active', 1]])->get();
}

?>
<div class="card">
	<div class="card-header"><h5>Keep In View Service Report</h5></div>
	<div class="card-body">
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
					<th>Proceed</th>
					<th>Approve By</th>
					<th>Send By</th>
					<th>Invoice</th>
					<th>Remarks</th>
					<th>&nbsp</th>
				</tr>
			</thead>
			<tbody>
		@foreach($sr0 as $sr)
		@if( $sr->hasmanyserial()->whereNull('serial')->first() )
				<tr>
					<td>{!! $sr->id !!}</td>
					<td>{!! Carbon::parse($sr->date)->format('D, j M Y') !!}</td>
					<td>{!! $sr->belongtoinformby->name !!}</td>
					<td>
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
		@if( !is_null( $sr->hasmanyjob()->first() ) )
						{!! Carbon::parse($sr->hasmanyjob()->get()->max('date'))->format('D, j M Y') !!}
		@endif
					</td>
					<td>
		@if( !is_null($sr->belongtoproceed) )
						{!! $sr->belongtoproceed->proceed !!}
		@endif
					</td>
					<td>
		<?php
		$di = \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
		// echo $sr->whereNull('approved_by')->first();
		?>
		@if( is_null( $sr->approved_by ) )
			@if( $di->group_id == 1 || $di->id == 29 )
				@if(!is_null($sr->approved_by))
								{{ $sr->belongtoapprovedby->name }}
				@else
								<div class="approval text-primary" data-id="{!! $sr->id !!}"><i class="far fa-check-square"></i></div>
				@endif
			@else
							Only Director or HOD can approve
			@endif
		@else
							{!! $sr->belongtoapprovedby->name !!}
		@endif
					</td>
					<td>
		@if(!is_null($sr->belongtosendby))
						{{ $sr->belongtosendby->name }}
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
						<a href="{!! route('serviceReport.show', $sr->id) !!}" target="_blank" title="Show"><i class="far fa-eye"></i></a>
						<a href="{!! route('serviceReport.editkiv', $sr->id) !!}" title="Update"><i class="far fa-edit"></i></a>
						<span class="text-danger inactivate" data-id="{!! $sr->id !!}" title="Delete"><i class="far fa-trash-alt"></i></span>
					</td>
				</tr>
		@endif
		@endforeach
			</tbody>
		</table>
	</div>
</div>

<p>&nbsp;</p>

<div class="card">
	<div class="card-header"><h5>Pending Service Report</h5></div>
	<div class="card-body">
		<table class="table table-hover" style="font-size:12px" id="servicereport4">
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
					<th>Proceed</th>
					<th>Approve By</th>
					<th>Send By</th>
					<th>Invoice</th>
					<th>Remarks</th>
					<th>&nbsp</th>
				</tr>
			</thead>
			<tbody>
		@foreach($sr0 as $sr)
		@if( !$sr->hasmanyjob()->first() )
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
		@if( !is_null( $sr->hasmanyjob()->first() ) )
						{!! Carbon::parse($sr->hasmanyjob()->get()->max('date'))->format('D, j M Y') !!}
		@endif
					</td>
					<td>
		@if( !is_null($sr->belongtoproceed) )
						{!! $sr->belongtoproceed->proceed !!}
		@endif
					</td>
					<td>
		<?php
		$di = \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
		?>
		@if( $di->group_id == 1 || $di->id == 29 )
				@if(!is_null($sr->approved_by))
								{{ $sr->belongtoapprovedby->name }}
				@else
								<div class="approval text-primary" data-id="{!! $sr->id !!}"><i class="far fa-check-square"></i></div>
				@endif
		@else
						Only Director or HOD can approve
		@endif
					</td>
					<td>
		@if(!is_null($sr->belongtosendby))
						{{ $sr->belongtosendby->name }}
		@endif
					</td>
					<td>
		@if( !is_null( $sr->belongtoinvoice ))
						{!! $sr->belongtoinvoice->DocNo !!}
		@else
						{!! __('No Invoice') !!}
		@endif
					</td>
					<td>
						{!! $sr->remarks !!}
					</td>
					<td>
						<a href="{!! route('serviceReport.show', $sr->id) !!}" target="_blank" title="Show"><i class="far fa-eye"></i></a>
						<a href="{!! route('serviceReport.edit', $sr->id) !!}" title="Update"><i class="far fa-edit"></i></a>
						<span class="text-danger inactivate" data-id="{!! $sr->id !!}"><i class="far fa-trash-alt"></i></span>
					</td>
				</tr>
		@endif
		@endforeach
			</tbody>
		</table>
	</div>
</div>

<p>&nbsp;</p>

<div class="card">
	<div class="card-header"><h5>Completed Service Report for Customer Service Department</h5></div>
	<div class="card-body">
		<table class="table table-hover" style="font-size:12px" id="servicereport5">
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
					<th>Proceed</th>
					<th>Approve By</th>
					<th>Checked By</th>
					<th>Send By</th>
					<th>Remarks</th>
					<th>Invoice</th>
					<th>&nbsp</th>
				</tr>
			</thead>
			<tbody>
		@foreach($sr0 as $sr)
		@if( $sr->hasmanyjob()->first() )
				<tr>
					<td>{!! $sr->id !!}</td>
					<td>{!! Carbon::parse($sr->date)->format('D, j M Y') !!}</td>
					<td>{!! $sr->belongtoinformby->name !!}</td>
					<td>
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
		@if( !is_null( $sr->hasmanyjob()->first() ) )
						{!! Carbon::parse($sr->hasmanyjob()->get()->max('date'))->format('D, j M Y') !!}
		@endif
					</td>
					<td>
		@if( !is_null($sr->belongtoproceed) )
						{!! $sr->belongtoproceed->proceed !!}
		@endif
					</td>
					<td>
		<?php
		$di = \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
		?>
		@if( $di->group_id == 1 || $di->id == 29 )
		@if(!is_null($sr->approved_by))
						{{ $sr->belongtoapprovedby->name }}
		@else
						<div class="approval text-primary" data-id="{!! $sr->id !!}"><i class="far fa-check-square"></i></div>
		@endif
		@else
						Only Director or HOD can approve
		@endif
					</td>
					<td>
		@if(!is_null( $sr->checked_by ))
						{{ $sr->belongtocheckedby->name }}
		@endif
					</td>
					<td>
		@if(!is_null($sr->send_by))
						{{ $sr->belongtosendby->name }}
		@else
			@if( !is_null($sr->checked_by) )
				@if($sr->proceed_id == 5)
					FOC Service Report
				@else
					<div class="send text-primary" data-id="{!! $sr->id !!}"><i class="far fa-check-square"></i></div>
				@endif
			@else
				Havent been checked yet
			@endif
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
						<a href="{!! route('serviceReport.show', $sr->id) !!}" target="_blank" title="Show"><i class="far fa-eye"></i></a>
						<a href="{!! route('serviceReport.edit', $sr->id) !!}" title="Update"><i class="far fa-edit"></i></a>
						<span class="text-danger inactivate" data-id="{!! $sr->id !!}"><i class="far fa-trash-alt"></i></span>
					</td>
				</tr>
		@endif
		@endforeach
			</tbody>
		</table>
	</div>
</div>

<p>&nbsp;</p>

<div class="card">
	<div class="card-header"><h5>Unapproved Service Report</h5></div>
	<div class="card-body">

{!! Form::open(['route' => ['serviceReport.updateunapprove'], 'id' => 'form', 'autocomplete' => 'off', 'files' => true,  'data-toggle' => 'validator']) !!}
		<table class="table table-hover" style="font-size:12px" id="servicereport3">
			<thead>
				<tr>
					<th><input type="checkbox" id="selectAll"><label for="selectAll">Approved All</label></th>
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
					<td>
						<label for="cb{{ $sr->id }}"><input type="checkbox" value="{{ $sr->id }}" name="approved_by[]" id="cb{{ $sr->id }}" class="checkbox1">&nbsp;</label>
					</td>
					<td>{!! $sr->id !!}</td>
					<td>{!! Carbon::parse($sr->date)->format('D, j M Y') !!}</td>
					<td>{!! $sr->belongtoinformby->name !!}</td>
					<td>
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
		@if( !is_null( $sr->hasmanyjob()->first() ) )
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
		<?php
		$di = \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
		?>
		@if( $di->group_id == 1 || $di->id == 29 )
						<div class="approval text-primary" data-id="{!! $sr->id !!}"><i class="far fa-check-square"></i></div>
		@else
						Only Director or HOD can approve
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
						<a href="{!! route('serviceReport.show', $sr->id) !!}" target="_blank" title="Show"><i class="far fa-eye"></i></a>
						<a href="{!! route('serviceReport.edit', $sr->id) !!}" title="Update"><i class="far fa-edit"></i></a>
						<span class="text-danger inactivate" data-id="{!! $sr->id !!}"><i class="far fa-trash-alt"></i></span>
					</td>
				</tr>
		@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan="15">
						{!! Form::button('Approved All', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
					</td>
				</tr>
			</tfoot>
		</table>
{{ Form::close() }}
	</div>
</div>

<p>&nbsp;</p>

<div class="card">
	<div class="card-header"><h5>Approved Service Report</h5></div>
	<div class="card-body">
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
		@foreach($sre as $sr)
				<tr>
					<td>{!! $sr->id !!}</td>
					<td>{!! Carbon::parse($sr->date)->format('D, j M Y') !!}</td>
					<td>{!! $sr->belongtoinformby->name !!}</td>
					<td>
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
		@if( !is_null( $sr->hasmanyjob()->first() ) )
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
		@if(!is_null($sr->belongtoapprovedby))
						{!! $sr->belongtoapprovedby->name !!}
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
						<a href="{!! route('serviceReport.show', $sr->id) !!}" target="_blank" title="Show"><i class="far fa-eye"></i></a>
						<a href="{!! route('serviceReport.edit', $sr->id) !!}" title="Update"><i class="far fa-edit"></i></a>
						<span class="text-danger inactivate" data-id="{!! $sr->id !!}"><i class="far fa-trash-alt"></i></span>
					</td>
				</tr>
		@endforeach
			</tbody>
		</table>
	</div>
</div>
<p>&nbsp;</p>
