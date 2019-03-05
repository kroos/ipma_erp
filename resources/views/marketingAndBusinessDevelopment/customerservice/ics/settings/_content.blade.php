<div class="card">
	<div class="card-header">Service Report FLOAT TH Constant</div>
	<div class="card-body">
		
		<table class="table table-hover table-sm" style="font-size:12px" id="servicereportconstant1">
			<thead>
				<tr>
					<th rowspan="2">ID</th>
					<th colspan="2">Overtime Rate</th>
					<th rowspan="2">Accommodation Rate</th>
					<th rowspan="2">Mileage Rate</th>
					<th rowspan="2">Hour Rate</th>
					<th rowspan="2">Active</th>
					<th rowspan="2">&nbsp;</th>
				</tr>
				<tr>
					<th>Constant 1</th>
					<th>Constant 2</th>
					<!-- <th colspan="2">&nbsp;</th> -->
				</tr>
			</thead>
			<tbody>
@foreach(\App\Model\ICSFloatthConstant::all() as $src)
				<tr>
					<td>{!! $src->id !!}</td>
					<td>{!! $src->overtime_constant_1 !!}</td>
					<td>{!! $src->overtime_constant_2 !!}</td>
					<td>{!! $src->accomodation_rate !!}</td>
					<td>{!! $src->travel_meter_rate !!}</td>
					<td>{!! $src->travel_hour_rate !!}</td>
					<td>{!! $src->active !!}</td>
					<td>
						<a href="{!! route('srConstant.edit', $src->id) !!}" title="Update"><i class="far fa-edit"></i></a>
					</td>
				</tr>
@endforeach
			</tbody>
		</table>
	</div>
</div>