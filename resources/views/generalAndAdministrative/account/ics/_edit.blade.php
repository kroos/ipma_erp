<?php
use \App\Model\ICSSQLSRVInvoice;
use \App\Model\ICSSQLSRVInvoiceDTL;
?>
<div class="card">
	<div class="card-header"><h5>Set Invoice For Service Report {!! $serviceReport->id !!}</h5></div>
	<div class="card-body">

		<dl class="row">
			<dt class="col-sm-3">Service Report No : </dt>
			<dd class="col-sm-9">

				<ul class="list-group">
@foreach($serviceReport->hasmanyserial()->get() as $srs)
					<li class="list-group-item">{!! $srs->serial !!}</li>
@endforeach
				</ul>
			</dd>
		</dl>

		<div class="form-group row {{ $errors->has('invoice_id')?'has-error':'' }}">
			{!! Form::label('inv', 'Invoice : ', ['class' => 'col-sm-2 col-form-label']) !!}
			<div class="col-sm-10">
				<select name="invoice_id" id="inv" class="form-control" placeholder="Please choose">
					<option value="">Please choose</option>
@foreach( ICSSQLSRVInvoice::get() as $inv )
					<optgroup label="{!! $inv->DocNo !!}">
						<option value="{{ $inv->DocKey }}">
							{!! $inv->DocNo !!} |
<?php $i = 1 ?>
@foreach($inv->hasmanyivdtl()->get() as $ind)
							{!! $i++ !!} => {!! $ind->Description !!} |<br />
@endforeach
						</option>
@endforeach
					</optgroup>
				</select>
			</div>
		</div>

		<div class="form-group row {{ $errors->has('invoice_id')?'has-error':'' }}">
			{!! Form::label('invrem', 'Remarks : ', ['class' => 'col-sm-2 col-form-label']) !!}
			<div class="col-sm-10">
				{!! Form::textarea('invoice_remarks', @$value, ['class' => 'form-control', 'id' => 'invrem', 'placeholder' => 'Remarks']) !!}
			</div>
		</div>

	</div>
<div class="form-group row">
	<div class="col-sm-10 offset-sm-2">
		{!! Form::button('Save', ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
	</div>
</div>
</div>