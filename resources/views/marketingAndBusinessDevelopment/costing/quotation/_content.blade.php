<?php
use Carbon\Carbon;

?>
<p>&nbsp;</p>
<table class="table table-hover table-sm" style="font-size:12px" id="quot1">
	<thead>
		<tr>
			<td>ID</td>
			<td>Rev</td>
			<td>Date</td>
			<td>Customer</td>
			<td>PIC</td>
			<td>Subject</td>
			<td>Price</td>
			<td>&nbsp;</td>
		</tr>
	</thead>
	<tbody>
@foreach( \App\Model\QuotQuotation::where('active', 1)->get() AS $q )
<?php
// for ID
$dts = Carbon::parse($q->date);
$arr = str_split( $dts->format('Y'), 2 );

// price calculate
$qi = 0;
foreach($q->hasmanyquotsection()->get() as $q1){
	foreach($q1->hasmanyquotsectionitem()->get() as $q2){
		$qi += $q2->price_unit * $q2->quantity;
	}
}
// echo $qi.'<br />';
$qp = (($q->tax_value * $qi) / 100) + $qi;
?>
		<tr>
			<td>QT-{!! $q->id !!}/{!! $arr[1] !!}</td>
			<td>rev</td>
			<td>{!! $dts->format('D, j M Y') !!}</td>
			<td>{!! $q->belongtocustomer->customer !!}</td>
			<td>{!! $q->attn !!}</td>
			<td>{!! $q->subject !!}</td>
			<td>{!! $q->belongtocurrency->iso_code !!} {!! number_format((float) $qp, 2, '.', ''); !!}</td>
			<td>
				<a href="{!! route('quot.edit', $q->id) !!}" title="Update"><i class="far fa-edit"></i></a>
				<span class="text-danger inactivate" data-id="{!! $q->id !!}" title="Delete"><i class="far fa-trash-alt"></i></span>
			</td>
		</tr>
@endforeach
	</tbody>
</table>